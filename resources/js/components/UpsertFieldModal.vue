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
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                    <div class="mt-1">
                                        <input :value="field.title" id="title" name="title" type="text"
                                            @input="updateTitle($event.target.value)" autocomplete="email" required=""
                                            class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" />
                                    </div>
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                    <select :value="field.type" id="type" name="type"
                                        @input="updateType($event.target.value)"
                                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                        <option value="date">Date</option>
                                        <option value="number">Number</option>
                                        <option value="string">String</option>
                                        <option value="boolean">Boolean</option>
                                    </select>
                                </div>


                                <div>
                                    <button type="submit" @click.prevent="upsertField"
                                        class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        {{ field.id === null ? 'Add ' : 'Update' }}
                                        Field</button>
                                </div>
                                <input type="hidden" :value="field.id" />
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

import { useFieldsStore } from '../stores/FieldsStore.js'

const props = defineProps(['open', 'field'])
const emit = defineEmits(['update:open', 'update:field'])

const { addField, updateField } = useFieldsStore()

const closeModal = () => {
    emit('update:open', false)
}

const updateTitle = (value) => {
    props.field.title = value
    emit('update:field', props.field)
}

const updateType = (value) => {
    props.field.type = value
    emit('update:field', props.field)
}

const upsertField = () => {
    closeModal()

    if (props.field.id !== null) {
        updateField(props.field)
    } else {

        addField(props.field.title, props.field.type)
    }
}

</script>
