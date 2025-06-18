<template>
    <div class="min-h-screen bg-gray-50">
        <header
            class="flex items-center justify-between bg-white shadow-md px-6 py-4 sticky top-0 z-40"
        >
            <h1
                class="text-3xl font-bold text-gray-800 mx-auto absolute left-1/2 transform -translate-x-1/2"
            >
                Task Manager
            </h1>

            <button
                @click="logout"
                class="ml-auto bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded shadow transition"
            >
                Logout
                <i class="ms-2 bi bi-box-arrow-right"></i>
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
                                <option disabled value="">
                                    Select a category
                                </option>
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
                    <form
                        @submit.prevent="createCategory"
                        class="flex gap-4 mb-6"
                    >
                        <input
                            v-model="categoryForm.name"
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
                    <ul>
                        <li
                            v-for="category in categories"
                            :key="category.id"
                            class="flex justify-between items-center border-b border-gray-200 py-2"
                        >
                            <div
                                v-if="editCategoryId === category.id"
                                class="flex gap-2 flex-grow"
                            >
                                <input
                                    v-model="editCategoryName"
                                    type="text"
                                    class="flex-grow border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                                />
                                <button
                                    @click="updateCategory(category)"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 rounded-md"
                                >
                                    Save
                                </button>
                                <button
                                    @click="cancelEdit"
                                    class="bg-gray-400 hover:bg-gray-500 text-white px-3 rounded-md"
                                >
                                    Cancel
                                </button>
                            </div>
                            <div v-else class="flex-grow">
                                {{ category.name }}
                            </div>

                            <div class="flex gap-2">
                                <button
                                    @click="startEditCategory(category)"
                                    class="text-warning hover:text-warning-dark"
                                    title="Edit"
                                >
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button
                                    @click="deleteCategory(category.id)"
                                    class="text-red-500 hover:text-red-700"
                                    title="Delete"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </li>
                    </ul>
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
                    v-if="filteredTasks.length"
                    class="space-y-3 max-h-[600px] overflow-auto"
                >
                    <li
                        v-for="task in filteredTasks"
                        :key="task.id"
                        class="border rounded p-3 flex justify-between items-start"
                    >
                        <div class="flex items-start gap-3">
                            <input
                                type="checkbox"
                                :checked="task.is_completed === 1"
                                @change="toggleComplete(task)"
                                class="mt-1"
                            />
                            <div>
                                <h4 class="font-bold">
                                    Title {{ task.title }}
                                </h4>
                                <p>Description {{ task.description }}</p>
                                <p class="text-sm text-gray-600">
                                    Category:
                                    {{ task.category?.name || "None" }}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button
                                @click="editTask(task)"
                                class="text-warning hover:text-warning-dark"
                                title="Edit"
                            >
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button
                                @click="deleteTask(task.id)"
                                class="text-red-500 hover:text-red-700"
                                title="Delete"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </li>
                </ul>
                <p v-else class="text-gray-600 text-center">
                    No tasks available.
                </p>
            </section>
            <div
                v-if="showModal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
            >
                <div class="bg-white p-6 rounded shadow-lg w-96">
                    <h2 class="text-xl font-bold mb-4 text-center">
                        Edit Task
                    </h2>

                    <hr />
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium">Title:</label>
                            <input
                                v-model="editForm.title"
                                type="text"
                                class="w-full border rounded p-2"
                            />
                        </div>
                        <div>
                            <label class="block font-medium"
                                >Description:</label
                            >
                            <textarea
                                v-model="editForm.description"
                                class="w-full border rounded p-2"
                            ></textarea>
                        </div>
                        <div>
                            <label class="block font-medium">Category:</label>
                            <select
                                v-model="editForm.category_id"
                                class="w-full border rounded p-2"
                            >
                                <option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button
                                @click="showModal = false"
                                class="px-4 py-2 border rounded"
                            >
                                Cancel
                            </button>
                            <button
                                @click="updateTask"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                            >
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

const categoryForm = ref({ name: "" });
const editCategoryId = ref(null);
const editCategoryName = ref("");
const showCategoryModal = ref(false);
const taskFilterCategory = ref("");

const filteredTasks = computed(() => {
    if (!taskFilterCategory.value) {
        return tasks.value;
    }
    return tasks.value.filter(
        (t) => String(t.category_id) === String(taskFilterCategory.value)
    );
});

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

const fetchCategories = async () => {
    try {
        const response = await axios.get("/api/categories", {
            withCredentials: true,
        });
        categories.value = response.data;
    } catch (error) {
        console.error("Error fetching categories:", error);
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

const deleteTask = async (id) => {
    try {
        await axios.delete(`/api/tasks/${id}`, { withCredentials: true });
        await fetchTasks();
    } catch (error) {
        console.error("Error deleting task:", error);
    }
};

const toggleComplete = async (task) => {
    try {
        await axios.patch(
            `/api/tasks/${task.id}`,
            { is_completed: task.is_completed === 1 ? 0 : 1 },
            { withCredentials: true }
        );
        await fetchTasks();
    } catch (error) {
        console.error("Error updating completion:", error);
    }
};

const editTask = (task) => {
    editForm.value = { ...task };
    showModal.value = true;
};

const updateTask = async () => {
    try {
        await axios.put(`/api/tasks/${editForm.value.id}`, editForm.value, {
            withCredentials: true,
        });
        showModal.value = false;
        await fetchTasks();
    } catch (error) {
        console.error("Error updating task:", error);
    }
};

const createCategory = async () => {
    try {
        await axios.post("/api/categories", categoryForm.value, {
            withCredentials: true,
        });
        categoryForm.value.name = "";
        await fetchCategories();
    } catch (error) {
        console.error("Error creating category:", error);
    }
};

const startEditCategory = (category) => {
    editCategoryId.value = category.id;
    editCategoryName.value = category.name;
};

const cancelEdit = () => {
    editCategoryId.value = null;
    editCategoryName.value = "";
};

const deleteCategory = async (id) => {
    try {
        await axios.delete(`/api/categories/${id}`, { withCredentials: true });
        await fetchCategories();
        await fetchTasks();
    } catch (e) {
        console.error("Failed to delete category", e);
    }
};

const updateCategory = async (category) => {
    try {
        const newName = editCategoryName.value;
        await axios.put(
            `/api/categories/${category.id}`,
            {
                id: category.id,
                name: newName,
            },
            { withCredentials: true }
        );

        showCategoryModal.value = false;
        editCategoryId.value = null;
        editCategoryName.value = "";

        await fetchCategories();
        await fetchTasks();
    } catch (error) {
        console.error(
            "Failed to update category:",
            error.response?.data ?? error.message
        );
    }
};

const logout = async () => {
    try {
        await axios.post("/logout", {}, { withCredentials: true });
        // Redirect to login page (adjust URL if needed)
        window.location.href = "/login";
    } catch (error) {
        console.error("Logout failed:", error);
    }
};

onMounted(async () => {
    await axios.get("/sanctum/csrf-cookie", { withCredentials: true });
    await fetchTasks();
    await fetchCategories();
});
</script>
