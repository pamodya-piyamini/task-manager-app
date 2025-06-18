<template>
     <header
        class="flex items-center justify-between bg-white shadow-md px-6 py-4 sticky top-0 z-40">
        <h1>Task Manager</h1>
        <button>Logout</button>
    </header>
    <div>
        <div class="flex flex-col flex-1">
            <section class="p-6">
                <h2>
                    Add New Task
                </h2>

            <form @submit.prevent="createTask">
                <div>
                    <label for="title">
                        Title
                    </label>
                    <input
                        type="text"
                        id="title"
                        placeholder="Enter task title"
                        required
                        v-model="form.title"
                    />
                </div>
                <div>
                    <label for="description">
                        Description
                    </label>
                    <textarea
                        v-model="form.description"
                        id="description"
                        placeholder="Describe your task"
                        rows="2">
                    </textarea>
                </div>
                <button type="submit">Add Task</button>
            </form>   
            </section>  

            <section>
                <h2>Manage Categories</h2>
                <form>
                    <input
                        type="text"
                        placeholder="Enter category name"
                        required
                    />
                    <button
                        type="submit">
                        Add
                    </button>
                </form>
            </section>
        </div>
        <section class="flex-1 p-6">
            <h2>
                Your Tasks
            </h2>
            <ul>
                 <li v-for="task in tasks" :key="task.id">
                    <div>
                        <input type="checkbox" />
                        <div>
                            <h4>Title {{ task.title }}</h4>
                            <p>Description {{ task.description }}</p>
                            <p>Category</p>
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