<template>
  <div>
    <div class="mb-4">
      <a-input
        type="text"
        v-model="search"
        placeholder="Search"
        class="w-1/3 mr-2"
      >
      </a-input>
    </div>
    <!-- admin table -->
    <a-table
      class="ant-table-striped"
      bordered
      :data-source="timeOffs"
      :columns="columns1"
      :loading="loading"
      :pagination="false"
      v-if="$store.state.auth.user.roles[0].name == 'Employee'"
    >
      <template slot="status" slot-scope="text, record, index">
        <div class="flex w-full">
          <a-tag v-if="record.is_approved == null" color="orange"
            >Pending</a-tag
          >
          <a-tag v-if="record.is_approved == 1" color="green">Approved</a-tag>
          <a-tag v-if="record.is_approved == 0" color="red">Declined</a-tag>
          <a-tag v-if="record.is_approved == 3" color="red">cancelled</a-tag>
        </div>
      </template>
      <template
        slot="action"
        slot-scope="text, record, index"
        v-if="$store.state.auth.user.roles[0].name == 'Employee'"
      >
        <div class="flex w-full">
          <a-button
            class="bg-red-600 text-white"
            :disabled="
              record.is_approved == 0 ||
              record.is_approved == 1 ||
              record.is_approved == 3
                ? true
                : false
            "
            label="Decline"
            @click="cancel(record)"
          >
            Cancel
          </a-button>
        </div>
      </template>
    </a-table>

    <!-- end of column one -->

    <!-- admin table -->
    <a-table
      class="ant-table-striped"
      bordered
      :data-source="timeOffs"
      :columns="admin"
      :loading="loading"
      :pagination="false"
      v-if="$store.state.auth.user.roles[0].name == 'Admin'"
    >
      <template slot="name" slot-scope="text, record, index">
        <div class="flex w-full">
          {{ record.user.firstname + " " + record.user.lastname }}
        </div>
      </template>
      <template slot="type" slot-scope="text, record, index">
        <div class="flex w-full">
          {{ record.type.name }}
        </div>
      </template>
      <template slot="status" slot-scope="text, record, index">
        <a-tag v-if="record.is_approved == null" color="orange">Pending</a-tag>
        <a-tag v-if="record.is_approved == 1" color="green">Approved</a-tag>
        <a-tag v-if="record.is_approved == 0" color="red">Declined</a-tag>
        <a-tag v-if="record.is_approved == 3" color="red">Cancelled</a-tag>
      </template>
    </a-table>

    <!-- manager table -->
    <a-table
      class="ant-table-striped"
      bordered
      :data-source="timeOffs"
      :columns="manager"
      :loading="loading"
      :pagination="false"
      v-if="$store.state.auth.user.roles[0].name == 'Manager'"
    >
      <template slot="name" slot-scope="text, record, index">
        <div class="flex w-full">
          {{ record.user.firstname + " " + record.user.lastname }}
        </div>
      </template>
      <template slot="status" slot-scope="text, record, index">
        <div class="flex w-full">
          <a-tag v-if="record.is_approved == null" color="orange"
            >Pending</a-tag
          >
          <a-tag v-if="record.is_approved == 1" color="green">Approved</a-tag>
          <a-tag v-if="record.is_approved == 0" color="red">Declined</a-tag>
          <a-tag v-if="record.is_approved == 3" color="red">cancelled</a-tag>
        </div>
      </template>
      <template slot="action" slot-scope="text, record, index">
        <div class="flex w-full">
          <a-button
            class="bg-red-600 mr-4 text-white"
            label="Decline"
            @click="decline(record)"
            :disabled="
              record.is_approved == 0 ||
              record.is_approved == 1 ||
              record.is_approved == 3
                ? true
                : false
            "
          >
            Decline
          </a-button>
          <a-button
            class="bg-green-600 text-white"
            label="Decline"
            @click="approve(record)"
            :disabled="
              record.is_approved == 0 ||
              record.is_approved == 1 ||
              record.is_approved == 3
                ? true
                : false
            "
          >
            Approve
          </a-button>
        </div>
      </template>
    </a-table>
    <div class="flex w-full justify-end pt-6">
      <a-pagination
        @change="handlePagination"
        v-model="pagination.current"
        :total="pagination.total"
        show-less-items
      />
    </div>
  </div>
</template>
<script>
export default {
  created() {
    this.allTimeOffs();
  },
  mounted() {
    this.$nuxt.$on("saveTimeOff", () => {
      this.allTimeOffs();
    });
  },
  watch: {
    search(val) {
      if (val == "") {
        this.allTimeOffs();
      } else {
        this.searchData();
      }
    },
  },
  methods: {
    async allTimeOffs(page) {
      this.loading = true;
      let data = await this.getTimeOffs(page);
      this.timeOffs = data.data.data;
      this.loading = false;
      this.pagination = {
        current: data.data.current_page,
        total: parseInt(data.data.last_page + 0),
      };
      console.log("timesss offsssssss", this.timeOffs);
    },
    async searchData() {
      this.loading = true;
      let found = await this.$axios.post(`/api/search_by_name`, {
        item: this.search,
      });

      this.timeOffs = found.data;
      console.log("this timeofss", this.timeOffs);
      this.loading = false;
    },
    async decline(record) {
      record.is_approved = 0;
      await this.declineOrApprove(record);
      this.allTimeOffs();
    },
    async approve(record) {
      record.is_approved = 1;
      console.log(record);
      // await this.declineOrApprove(record);
      // this.allTimeOffs();
    },
    async cancel(record) {
      this.loading = true;
      record.isApproved = 3;
      await this.updateTimeOffs(record);
      this.allTimeOffs();
      this.loading = false;
    },
    async handlePagination(page) {
      this.pagination.current = page;
      await this.allTimeOffs(page);
    },
  },
  data() {
    return {
      timeOffs: null,
      loading: false,
      columns1: [
        { title: "Type", dataIndex: "type.name" },
        { title: "Start Date", dataIndex: "start_date" },
        { title: "End Date", dataIndex: "end_date" },
        {
          title: "Status",
          dataIndex: "status",
          scopedSlots: { customRender: "status" },
        },
        {
          title: "Action",
          dataIndex: "action",
          scopedSlots: { customRender: "action" },
        },
      ],
      admin: [
        {
          title: "Name",
          dataIndex: "name",
          scopedSlots: { customRender: "name" },
        },
        { title: "Start Date", dataIndex: "start_date" },
        { title: "End Date", dataIndex: "end_date" },
        {
          title: "Type",
          dataIndex: "type",
          scopedSlots: { customRender: "type" },
        },
        {
          title: "Status",
          dataIndex: "status",
          scopedSlots: { customRender: "status" },
        },
      ],
      manager: [
        {
          title: "Name",
          dataIndex: "name",
          scopedSlots: { customRender: "name" },
        },
        { title: "Start Date", dataIndex: "start_date" },
        { title: "End Date", dataIndex: "end_date" },
        {
          title: "Status",
          dataIndex: "status",
          scopedSlots: { customRender: "status" },
        },
        {
          title: "Action",
          dataIndex: "action",
          scopedSlots: { customRender: "action" },
        },
      ],
      pagination: {
        current: 2,
        total: 10,
      },
      search: "",
    };
  },
};
</script>
<style scoped>
.ant-table-striped :deep(.table-striped) td {
  background-color: #fafafa;
}
</style>
