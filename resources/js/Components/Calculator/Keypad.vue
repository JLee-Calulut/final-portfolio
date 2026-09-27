<script setup>
import { computed } from 'vue';

const props = defineProps({
    activeOperator: { type: String, default: null },
});

const emit = defineEmits([
    'digit',
    'decimal',
    'operator',
    'equals',
    'percent',
    'sign',
    'clear',
    'backspace',
]);

const keys = [
    { id: 'ac', label: 'AC', type: 'fn', action: () => emit('clear') },
    { id: 'backspace', label: '⌫', type: 'fn', action: () => emit('backspace') },
    { id: 'percent', label: '%', type: 'fn', action: () => emit('percent') },
    { id: 'divide', label: '÷', type: 'op', token: '/' },
    { id: '7', label: '7', type: 'digit', digit: '7' },
    { id: '8', label: '8', type: 'digit', digit: '8' },
    { id: '9', label: '9', type: 'digit', digit: '9' },
    { id: 'multiply', label: '×', type: 'op', token: '*' },
    { id: '4', label: '4', type: 'digit', digit: '4' },
    { id: '5', label: '5', type: 'digit', digit: '5' },
    { id: '6', label: '6', type: 'digit', digit: '6' },
    { id: 'subtract', label: '−', type: 'op', token: '-' },
    { id: '1', label: '1', type: 'digit', digit: '1' },
    { id: '2', label: '2', type: 'digit', digit: '2' },
    { id: '3', label: '3', type: 'digit', digit: '3' },
    { id: 'add', label: '+', type: 'op', token: '+' },
    { id: 'sign', label: '±', type: 'fn', action: () => emit('sign') },
    { id: '0', label: '0', type: 'digit', digit: '0' },
    { id: 'decimal', label: '.', type: 'fn', action: () => emit('decimal') },
    { id: 'equals', label: '=', type: 'equals', action: () => emit('equals') },
];

const keyClass = computed(() => ({
    base: [
        'flex h-14 select-none items-center justify-center rounded-xl border text-lg font-semibold',
        'transition duration-200 active:scale-95',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-500',
        'md:h-16',
    ].join(' '),
    fn: 'border-ink-border bg-ink text-neutral-300 hover:border-neutral-600 hover:text-white',
    digit: 'border-ink-border bg-ink-card text-white hover:border-neutral-600 hover:bg-white/5',
    op: 'border-ink-border bg-ink-card text-orange-400 hover:border-orange-500/50 hover:text-orange-300',
    opActive: 'border-orange-500 bg-orange-500 text-black',
    equals: 'border-orange-500 bg-orange-500 text-black hover:bg-orange-400',
}));

function press(key) {
    if (key.type === 'digit') emit('digit', key.digit);
    else if (key.type === 'op') emit('operator', key.token);
}
</script>

<template>
    <div class="grid grid-cols-4 gap-2.5 md:gap-3">
        <button
            v-for="key in keys"
            :key="key.id"
            type="button"
            :class="[
                keyClass.base,
                key.type === 'op'
                    ? (activeOperator === key.label ? keyClass.opActive : keyClass.op)
                    : key.type === 'equals' ? keyClass.equals
                    : key.type === 'fn' ? keyClass.fn
                    : keyClass.digit,
            ]"
            :aria-label="key.id === 'equals' ? 'Equals' : key.label"
            @click="key.action ? key.action() : press(key)"
        >
            {{ key.label }}
        </button>
    </div>
</template>
