<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Email</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        State</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Fields</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <button type="button"
                                            class="inline-flex items-center rounded-full border border-transparent bg-indigo-600 p-1 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            <PlusIcon class="h-5 w-5" @click="openUpsertModal(emptySubscriber)"
                                                aria-hidden="true" />
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="subscriber in subscribers" :key="subscriber.id">
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ subscriber.name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ subscriber.email }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ subscriber.state }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <a href="#" @click="openFieldsModal(subscriber)"
                                            class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">{{
                                                Object.keys(subscriber.fields).length
                                            }}</a>
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="#" class="text-indigo-600 mx-1 hover:text-indigo-900">
                                            <PencilSquareIcon class="h-5 w-5 inline"
                                                @click="openUpsertModal(subscriber)" />
                                        </a>
                                        <a href="#" @click="deleteSubscriber(subscriber.id)"
                                            class="text-red-600 mx-1 hover:text-red-900">
                                            <TrashIcon class="h-5 w-5 inline" />
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <UpsertSubscriberModal v-model:open="subscriberModalIsOpen" v-model:subscriber="modalSubscriber" />
    <FieldsModal v-model:open="fieldsModalIsOpen" v-model:fields="modalFields" :subscriber="modalFieldsSubscriber" />
</template>

<script setup>
import { PlusIcon, TrashIcon, PencilSquareIcon } from '@heroicons/vue/20/solid'
import { ref } from 'vue';
import { useSubscriberStore } from "./../stores/SubscriberStore.js"
import UpsertSubscriberModal from './UpsertSubscriberModal.vue';
import FieldsModal from './FieldsModal.vue'

const { subscribers, loadSubscribers, deleteSubscriber } = useSubscriberStore();

const emptySubscriber = { id: null, name: '', email: '', state: '' }

const subscriberModalIsOpen = ref(false);
const modalSubscriber = ref(emptySubscriber);

const fieldsModalIsOpen = ref(false)
const modalFields = ref([])
const modalFieldsSubscriber = ref(null)

const openUpsertModal = (subscriber) => {
    modalSubscriber.value = subscriber
    subscriberModalIsOpen.value = true
}

const openFieldsModal = (subscriber) => {
    modalFieldsSubscriber.value = subscriber.id
    modalFields.value = subscriber.fields
    fieldsModalIsOpen.value = true
}

loadSubscribers()
</script>
