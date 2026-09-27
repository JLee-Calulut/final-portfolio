<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import AppIcon from '@/Components/UI/AppIcon.vue';

const page = usePage();

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const flashSuccess = computed(() => page.props.flash?.success);

function submit() {
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}

const inputClasses =
    'w-full rounded-xl border bg-ink-soft px-4 py-3 text-sm text-white placeholder-neutral-600 transition duration-300 focus:border-orange-500 focus:ring-orange-500';

const errorClasses = 'mt-2 text-sm text-red-400';

function fieldClass(field) {
    return form.errors[field]
        ? `${inputClasses} border-red-500/60`
        : `${inputClasses} border-ink-border`;
}
</script>

<template>
    <form class="reveal space-y-5" novalidate @submit.prevent="submit">
        <!-- Success message (flash from Laravel) -->
        <div
            v-if="flashSuccess"
            role="status"
            class="flex items-center gap-3 rounded-xl border border-orange-500/40 bg-orange-500/10 px-4 py-3 text-sm text-orange-300"
        >
            <AppIcon name="check" class="h-5 w-5 shrink-0" />
            {{ flashSuccess }}
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="contact-name" class="mb-2 block text-sm font-medium text-neutral-300">Name</label>
                <input
                    id="contact-name"
                    v-model="form.name"
                    type="text"
                    name="name"
                    autocomplete="name"
                    placeholder="Your name"
                    :class="fieldClass('name')"
                    :aria-invalid="!!form.errors.name"
                    aria-describedby="contact-name-error"
                >
                <p v-if="form.errors.name" id="contact-name-error" :class="errorClasses">{{ form.errors.name }}</p>
            </div>

            <div>
                <label for="contact-email" class="mb-2 block text-sm font-medium text-neutral-300">Email</label>
                <input
                    id="contact-email"
                    v-model="form.email"
                    type="email"
                    name="email"
                    autocomplete="email"
                    placeholder="you@example.com"
                    :class="fieldClass('email')"
                    :aria-invalid="!!form.errors.email"
                    aria-describedby="contact-email-error"
                >
                <p v-if="form.errors.email" id="contact-email-error" :class="errorClasses">{{ form.errors.email }}</p>
            </div>
        </div>

        <div>
            <label for="contact-subject" class="mb-2 block text-sm font-medium text-neutral-300">Subject</label>
            <input
                id="contact-subject"
                v-model="form.subject"
                type="text"
                name="subject"
                placeholder="What's this about?"
                :class="fieldClass('subject')"
                :aria-invalid="!!form.errors.subject"
                aria-describedby="contact-subject-error"
            >
            <p v-if="form.errors.subject" id="contact-subject-error" :class="errorClasses">{{ form.errors.subject }}</p>
        </div>

        <div>
            <label for="contact-message" class="mb-2 block text-sm font-medium text-neutral-300">Message</label>
            <textarea
                id="contact-message"
                v-model="form.message"
                name="message"
                rows="6"
                placeholder="Tell me about your project…"
                :class="fieldClass('message')"
                :aria-invalid="!!form.errors.message"
                aria-describedby="contact-message-error"
            />
            <p v-if="form.errors.message" id="contact-message-error" :class="errorClasses">{{ form.errors.message }}</p>
        </div>

        <div class="pt-1">
            <PrimaryButton type="submit" :disabled="form.processing">
                <span v-if="form.processing">Sending…</span>
                <span v-else class="inline-flex items-center gap-2">
                    Send Message
                    <AppIcon name="arrow-right" class="h-4 w-4" />
                </span>
            </PrimaryButton>
        </div>
    </form>
</template>
