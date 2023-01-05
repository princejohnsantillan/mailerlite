<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="closeModal">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <form class="space-y-6" action="#" method="POST">
                                <div v-for="field in fieldsList" :key="field.id">
                                    <label :for="field.title" class="block text-sm font-medium text-gray-700"><span
                                            class="capitalize">{{ field.title }}</span></label>
                                    <div class="mt-1">
                                        <input :name="field.title" type="text" autocomplete="email" required=""
                                            :value="fields[field.title] ?? ''"
                                            @input="updateField(field.title, $event.target.value)"
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" @click.prevent="saveFields"
                                        class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Save</button>
                                </div>
                            </form>
                            <div class="mt-5 sm:mt-6">
                                <button type="button"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm"
                                    @click="closeModal">Go back to dashboard</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useSubscriberStore } from '../stores/SubscriberStore';
import { useFieldsStore } from "./../stores/FieldsStore.js"

const props = defineProps(['open', 'fields', 'subscriber'])
const emit = defineEmits(['update:open', 'update:fields'])

const { fields: fieldsList } = useFieldsStore()
const { saveSubscriberFields } = useSubscriberStore()

const closeModal = () => {
    emit('update:open', false)
}

const updateField = (key, value) => {
    props.fields[key] = value
    emit('update:fields', props.fields)
}

const saveFields = () => {
    closeModal()

    let newFields = []
    let newValue = ''

    for (const x in fieldsList.value) {
        newValue = props.fields[fieldsList.value[x].title] ?? ''

        if (newValue !== '') {
            newFields.push({ id: fieldsList.value[x].id, value: newValue })
        }
    }

    saveSubscriberFields(props.subscriber, newFields)
}
</script>
