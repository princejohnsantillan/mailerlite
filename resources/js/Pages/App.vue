<template>
    <div class="min-h-full">
        <main class="pb-8">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">

                <!-- Main 3 column grid -->
                <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
                    <!-- Left column -->
                    <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                        <section aria-labelledby="section-1-title">

                            <div class="overflow-hidden rounded-lg bg-white shadow">

                                <div class="p-6">
                                    <Divider label="Subscribers" />
                                    <SubscribersTable />
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Right column -->
                    <div class="grid grid-cols-1 gap-4">
                        <section aria-labelledby="section-2-title">

                            <div class="overflow-hidden rounded-lg bg-white shadow">
                                <div class="p-6">
                                    <Divider label="Fields" />
                                    <FieldsTable />
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </main>
    </div>

</template>

<script setup>
import { ref } from "vue";

import Divider from "../components/Divider.vue"
import FieldsTable from "../components/FieldsTable.vue"
import SubscribersTable from "../components/SubscribersTable.vue"


</script>
