import { computed, ref } from 'vue';

/**
 * Calculator composable.
 *
 * Pure client-side logic for a standard calculator: chained operations,
 * percent, sign toggle, decimal handling, error handling (divide by zero),
 * an expression preview ("tape"), and a rolling history.
 *
 * Mirrors the portfolio's `use*` composable convention.
 */

// Symbols as they should appear on screen vs. how they're stored.
const SYMBOLS = { '+': '+', '-': '−', '*': '×', '/': '÷' };

// Keep the readout readable — no more than 12 significant digits.
const MAX_DIGITS = 12;

/** Round away binary floating-point artifacts (e.g. 0.1 + 0.2 → 0.3). */
function sanelyRounded(value) {
    const shifted = Math.round((value + Number.EPSILON) * 1e12) / 1e12;
    const fixed = parseFloat(shifted.toPrecision(MAX_DIGITS));
    return Object.is(fixed, -0) ? 0 : fixed;
}

/** Format a number for display: trim trailing zeros, keep it under MAX_DIGITS. */
export function formatForDisplay(value) {
    if (!Number.isFinite(value)) {
        return 'Error';
    }
    const s = value.toPrecision(MAX_DIGITS);
    // Turn scientific notation back into something readable when practical.
    let out = Number(s).toString();
    if (out.length > 14) {
        out = s;
    }
    return out;
}

function createCalculatorState() {
    // -- State -------------------------------------------------------------
    const current = ref('0');         // the operand being typed
    const previous = ref(null);       // stored accumulator once an operator is pending
    const operator = ref(null);       // '+', '-', '*', '/'
    const justEvaluated = ref(false); // true right after "="
    const error = ref(null);          // non-null = error state ("Cannot divide by zero")
    const history = ref([]);          // [{ id, expression, result }]

    // -- Helpers -----------------------------------------------------------
    const fmt = (value) => formatForDisplay(sanelyRounded(value));

    function pushHistory(expression, result) {
        history.value = [
            { id: Date.now() + Math.random(), expression, result: fmt(result) },
            ...history.value,
        ].slice(0, 20);
    }

    /** Perform the pending operation. Returns a number, or NaN + sets error. */
    function compute(a, b, op) {
        switch (op) {
            case '+': return sanelyRounded(a + b);
            case '-': return sanelyRounded(a - b);
            case '*': return sanelyRounded(a * b);
            case '/':
                if (b === 0) {
                    error.value = 'Cannot divide by zero';
                    return NaN;
                }
                return sanelyRounded(a / b);
            default: return NaN;
        }
    }

    // -- Public API ---------------------------------------------------------
    function clear() {
        current.value = '0';
        previous.value = null;
        operator.value = null;
        justEvaluated.value = false;
        error.value = null;
    }

    function clearHistory() {
        history.value = [];
    }

    function inputDigit(digit) {
        if (error.value) {
            clear();
        }
        if (justEvaluated.value) {
            // Typing a digit after "=" starts a fresh calculation.
            clear();
        }
        const text = String(digit);

        if (current.value === '0' && text !== '.') {
            current.value = text;
            return;
        }
        if (current.value.includes('.') && text === '.') {
            return; // already has a decimal point
        }
        if (current.value.replace('-', '').replace('.', '').length >= MAX_DIGITS) {
            return; // keep the readout under control
        }
        current.value += text;
    }

    function inputDecimal() {
        if (error.value || justEvaluated.value) {
            clear();
        }
        if (!current.value.includes('.')) {
            current.value += '.';
        }
    }

    function inputOperator(op) {
        if (error.value) {
            clear();
        }
        if (justEvaluated.value) {
            // Continue from the last result.
            previous.value = Number(current.value);
            operator.value = op;
            current.value = '';
            justEvaluated.value = false;
            return;
        }

        if (previous.value !== null && operator.value !== null && current.value !== '') {
            // Chain: resolve the pending operation first.
            const result = compute(previous.value, Number(current.value), operator.value);
            if (error.value) {
                return;
            }
            previous.value = result;
            operator.value = op;
            current.value = '';
            return;
        }

        if (previous.value === null) {
            previous.value = Number(current.value);
            operator.value = op;
            current.value = '';
            return;
        }

        // Operator pressed twice: just swap it.
        operator.value = op;
    }

    function inputEquals() {
        if (error.value || justEvaluated.value) {
            return;
        }
        if (previous.value === null || operator.value === null) {
            return;
        }
        const a = previous.value;
        const b = Number(current.value === '' ? previous.value : current.value);
        const result = compute(a, b, operator.value);
        if (error.value) {
            previous.value = null;
            operator.value = null;
            current.value = '0';
            justEvaluated.value = true;
            return;
        }

        pushHistory(`${fmt(a)} ${SYMBOLS[operator.value]} ${fmt(b)}`, result);

        current.value = fmt(result);
        previous.value = null;
        operator.value = null;
        justEvaluated.value = true;
    }

    function percent() {
        if (error.value) {
            return;
        }
        if (current.value === '' || justEvaluated.value) {
            current.value = fmt(Number(current.value) / 100);
            return;
        }
        current.value = fmt(Number(current.value) / 100);
    }

    function toggleSign() {
        if (error.value) {
            return;
        }
        if (current.value === '0' || current.value === '' || current.value === '0.') {
            return;
        }
        current.value = current.value.startsWith('-')
            ? current.value.slice(1)
            : `-${current.value}`;
    }

    function backspace() {
        if (error.value) {
            clear();
            return;
        }
        if (justEvaluated.value || current.value === '') {
            return;
        }
        current.value = current.value.length <= 1 || (current.value.length === 2 && current.value.startsWith('-'))
            ? '0'
            : current.value.slice(0, -1);
    }

    /** Reuse a past result as the starting point. */
    function reuseHistory(item) {
        current.value = item.result;
        previous.value = null;
        operator.value = null;
        justEvaluated.value = true;
        error.value = null;
    }

    // -- Derived display ----------------------------------------------------
    // The big readout.
    const display = computed(() => {
        if (error.value) {
            return error.value;
        }
        if (current.value === '') {
            return previous.value !== null ? fmt(previous.value) : '0';
        }
        return current.value;
    });

    // The "tape" line above the readout (e.g. "128 × 4").
    const preview = computed(() => {
        if (error.value || justEvaluated.value) {
            return '';
        }
        if (previous.value === null || operator.value === null) {
            return '';
        }
        const tape = `${fmt(previous.value)} ${SYMBOLS[operator.value]}`;
        return current.value !== '' ? `${tape} ${current.value}` : tape;
    });

    // Highlight the operator that is currently pending.
    const activeOperator = computed(() => (operator.value ? SYMBOLS[operator.value] : null));

    return {
        current,
        previous,
        operator,
        justEvaluated,
        error,
        history,
        display,
        preview,
        activeOperator,
        clear,
        clearHistory,
        inputDigit,
        inputDecimal,
        inputOperator,
        inputEquals,
        percent,
        toggleSign,
        backspace,
        reuseHistory,
    };
}

/**
 * Single shared instance for this one-screen app, so every component
 * (calculator keys, display, history panel) reads/writes the same state.
 */
const shared = createCalculatorState();

export function useCalculator() {
    return shared;
}

export default useCalculator;
