<script setup>
import { onBeforeUnmount, onMounted } from 'vue';
import useCalculator from '@/Composables/useCalculator';
import Display from '@/Components/Calculator/Display.vue';
import Keypad from '@/Components/Calculator/Keypad.vue';

const calc = useCalculator();

// -- Keyboard support -------------------------------------------------------
const KEY_MAP = {
    Escape: () => calc.clear(),
    Backspace: () => calc.backspace(),
    Enter: () => calc.inputEquals(),
    '=': () => calc.inputEquals(),
    '%': () => calc.percent(),
    '+': () => calc.inputOperator('+'),
    '-': () => calc.inputOperator('-'),
    '*': () => calc.inputOperator('*'),
    '/': () => calc.inputOperator('/'),
    '.': () => calc.inputDecimal(),
};

function onKeydown(event) {
    const { key } = event;

    if (/^[0-9]$/.test(key)) {
        calc.inputDigit(key);
        return;
    }

    const action = KEY_MAP[key];
    if (action) {
        event.preventDefault();
        action();
    }
}

onMounted(() => window.addEventListener('keydown', onKeydown));
onBeforeUnmount(() => window.removeEventListener('keydown', onKeydown));
</script>

<template>
    <div class="space-y-4">
        <Display :preview="calc.preview.value" :value="calc.display.value" />
        <Keypad
            :active-operator="calc.activeOperator.value"
            @digit="calc.inputDigit"
            @decimal="calc.inputDecimal"
            @operator="calc.inputOperator"
            @equals="calc.inputEquals"
            @percent="calc.percent"
            @sign="calc.toggleSign"
            @clear="calc.clear"
            @backspace="calc.backspace"
        />
    </div>
</template>
