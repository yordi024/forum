<template>
    <AppLayout>
        <Container>
            <ul class="divide-y">
                <li
                    class="px-2 py-4" 
                    v-for="post in posts"
                >
                    <span class="font-bold text-lg text-gray-700 dark:text-gray-300">
                        {{ post.title }}
                    </span>
                </li>
            </ul>
        </Container>
        
    </AppLayout>
</template>

<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";

defineProps(['posts']);

</script>