<template>
  <div class="relative p-2 flex overflow-x-auto h-full">
    <div
      v-for="status in statuses"
      :key="status.slug"
      class="mr-6 w-4/5 max-w-xs flex-1 flex-shrink-0"
    >
      <div class="rounded-md shadow-md overflow-hidden">
        <div class="p-3 flex justify-between items-baseline bg-blue-800 ">
          <h4 class="font-medium text-white">
            {{ status.title }}
          </h4>
          <button class="py-1 px-2 text-sm text-orange-500 hover:underline">
            タスク追加
          </button>
        </div>
        <div class="p-2 flex-1 flex flex-col h-full overflow-x-hidden overflow-y-auto bg-blue-100">
          <div
            v-for="task in status.tasks"
            :key="task.id"
            class="mb-3 p-3 h-24 flex flex-col bg-white rounded-md shadow transform hover:shadow-md cursor-pointer"
          >
            <span class="block mb-2 text-xl text-gray-900">
              {{ task.title }}
            </span>
            <p class="text-gray-700 truncate">
              {{ task.description }}
            </p>
          </div>

          <AddTaskForm
            v-if="newTaskForStatus === status.id"
            :status-id="status.id"
            v-on:task-added="handleTaskAdded"
            v-on:task-canceled="closeAddTaskForm"
          />

          <div
            v-show="!status.tasks.length && newTaskForStatus !== status.id"
            class="flex-1 p-4 flex flex-col items-center justify-center"
          >
            <span class="text-gray-600">No tasks yet</span>
            <button
              class="mt-1 text-sm text-orange-600 hover:underline"
              @click="openAddTaskForm(status.id)"
            >
              Add one
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AddTaskForm from "./AddTaskForm";

export default {
  components: { AddTaskForm },

  props: {
    initialData: Array
  },
  data() {
    return {
      statuses: [],

      newTaskForStatus: 0
    };
  },
  mounted() {
    this.statuses = JSON.parse(JSON.stringify(this.initialData));
  },
  methods: {
    // statusIdを設定し、フォームを表示
    openAddTaskForm(statusId) {
      this.newTaskForStatus = statusId;
    },
    // statusIdをリセットしてフォームを閉じる
    closeAddTaskForm() {
      this.newTaskForStatus = 0;
    },
    // ボードの正しい列にカードを追加
    handleTaskAdded(newTask) {
      // FInd the index of the status where we should add the newTask
      const statusIndex = this.statuses.findIndex(
        status => status.id === newTask.status_id
      );

      // 新しく作成しカードをボードに追加する
      this.statuses[statusIndex].tasks.push(newTask);

      // AddTaskFormを閉じる
      this.closeAddTaskForm();
    },
  }
};
</script>