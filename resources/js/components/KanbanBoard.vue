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

      <!-- あとで、ここにタスク追加フォームを入れます-->

          <div
            v-show="!status.tasks.length"
            class="flex-1 p-4 flex flex-col items-center justify-center"
          >
            <span class="text-gray-600">No tasks yet</span>
            <button
              class="mt-1 text-sm text-orange-600 hover:underline"
            >
              追加
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    initialData: Array
  },
  data() {
    return {
      statuses: []
    };
  },
  mounted() {
    this.statuses = JSON.parse(JSON.stringify(this.initialData));
  }
};
</script>