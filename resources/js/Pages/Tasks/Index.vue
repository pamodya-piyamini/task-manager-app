<template>
    <header
        class="flex items-center justify-between bg-white shadow-md px-6 py-4 sticky top-0 z-40"
    >
        <h1
            class="text-3xl font-bold text-gray-800 mx-auto absolute left-1/2 transform -translate-x-1/2"
        >
            Task Manager
        </h1>

        <button
            class="ml-auto bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded shadow transition"
        >
            Logout
        </button>
    </header>

    <div class="max-w-6xl mx-auto p-6 md:flex md:gap-12">
        <div
            class="flex flex-col flex-1 space-y-12 max-w-xl mx-auto md:max-w-none"
        >
            <section class="bg-white p-6 rounded-lg shadow-md">
                <h2
                    class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2 text-center"
                >
                    Add New Task
                </h2>

                <form @submit.prevent="createTask" class="space-y-6">
                    <div>
                        <label
                            for="title"
                            class="block text-gray-700 font-semibold mb-1"
                        >
                            Title
                        </label>
                        <input
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            type="text"
                            id="title"
                            placeholder="Enter task title"
                            required
                            v-model="form.title"
                        />
                    </div>
                    <div>
                        <label
                            for="description"
                            class="block text-gray-700 font-semibold mb-1"
                        >
                            Description
                        </label>
                        <textarea
                            v-model="form.description"
                            id="description"
                            placeholder="Describe your task"
                            rows="2"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        >
                        </textarea>
                    </div>
                    <div>
                        <label
                            for="category"
                            class="block text-gray-700 font-semibold mb-1"
                            >Category</label
                        >
                        <select
                            v-model="form.category_id"
                            id="category"
                            class="w-full border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                        >
                            <option disabled value="">Select a category</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3 rounded-md shadow-lg transition"
                    >
                        Add Task
                    </button>
                </form>
            </section>

            <section class="bg-white p-6 rounded-lg shadow-md">
                <h2
                    class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2 text-center"
                >
                    Manage Categories
                </h2>
                <form @submit.prevent="createCategory" class="flex gap-4 mb-6">
                    <input
                        v-model="form.name"
                        type="text"
                        placeholder="Enter category name"
                        required
                        class="flex-grow border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    />
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold px-6 rounded-md shadow-lg transition"
                    >
                        Add
                    </button>
                </form>
            </section>
        </div>
        <section
            class="flex-1 bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto md:max-w-none mt-12 md:mt-0"
        >
            <h2
                class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2 text-center flex items-center justify-center gap-4"
            >
                Your Tasks
            </h2>
            <div class="flex justify-end mb-4">
                <select
                    v-model="taskFilterCategory"
                    @change="filterTasks"
                    class="border border-gray-300 rounded-md p-1 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                >
                    <option value="">All</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <ul
                v-if="tasks.length > 0"
                class="space-y-3 max-h-[600px] overflow-auto"
            >
                <li
                    v-for="task in tasks"
                    :key="task.id"
                    class="border rounded p-3 flex justify-between items-start"
                >
                    <div class="flex items-start gap-3">
                        <input type="checkbox" />
                        <div>
                            <h4 class="font-bold">Title {{ task.title }}</h4>
                            <p>Description {{ task.description }}</p>
                            <p class="text-sm text-gray-600">
                                Category: {{ task.category?.name || "None" }}
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </section>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

const tasks = ref([]);
const categories = ref([]);
const form = ref({
    title: "",
    description: "",
    category_id: "",
});
const editForm = ref({});
const showModal = ref(false);

const fetchTasks = async () => {
    try {
        const response = await axios.get("/api/tasks", {
            withCredentials: true,
        });
        tasks.value = response.data;
    } catch (error) {
        console.error("Error fetching tasks:", error);
    }
};

const createTask = async () => {
    try {
        await axios.post("/api/tasks", form.value, { withCredentials: true });
        form.value = { title: "", description: "", category_id: "" };
        await fetchTasks();
    } catch (error) {
        console.error("Error creating task:", error);
    }
};

onMounted(async () => {
    await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
    await fetchTasks();
});
</script>
