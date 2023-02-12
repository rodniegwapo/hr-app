<template>
  <div>
    <div
      class="flex w-full"
      v-if="$store.state.auth.user.roles[0].name == 'Employee'"
    >
      <div class="w-1/3 pr-2">
        <addTime />
      </div>
      <div class="w-2/3 pl-2">
        <div class="text-xl pb-4">Time Off Request</div>
        <dataTable />
      </div>
    </div>
    <div v-else>
      <dataTable />
    </div>
  </div>
</template>
<script>
import addTime from "./__add";
import dataTable from "./__table";
export default {
  components: {
    addTime,
    dataTable,
  },
  created() {
    this.$nuxt.$on("saveTimeOff", () => {});
  },
  methods: {},
  data() {
    return {
      form: {},
    };
  },
};
</script>