<template>
  <div>
    <div class="w-1/2">
      <a-card>
        <div class="text-lg" v-if="request">
          {{ request.user.firstname + " " + request.user.lastname }} requesting
          for {{ request.type.name }} leave
        </div>
        <div v-if="request">
          <div class="pt-4">Start Date: {{ request.start_date }}</div>
          <div class="pt-4">End Date: {{ request.end_date }}</div>
          <div class="pt-4">Notes: {{ request.notes }}</div>
        </div>
        <div class="flex w-full pt-4" v-if="request">
          <a-button
            disabled
            class="bg-red-600 hover:bg-red-500 mr-2 hover:text-white text-white"
            large
            v-if="request.is_approved == 0"
          >
            Declined
          </a-button>
          <a-button
            disabled
            class="bg-red-600 hover:bg-red-500 mr-2 hover:text-white text-white"
            large
            v-if="request.is_approved == 1"
          >
            Approved
          </a-button>
          <a-button
            disabled
            class="bg-red-600 hover:bg-red-500 mr-2 hover:text-white text-white"
            large
            v-if="request.is_approved == 3"
          >
            Cancelled
          </a-button>
          <a-button
            @click="decline(request)"
            :loading="loading"
            class="bg-red-600 hover:bg-red-500 mr-2 hover:text-white text-white"
            large
            v-if="request.is_approved == null"
          >
            Declined
          </a-button>
          <a-button
            @click="approve(request)"
            :loading="loading"
            class="bg-blue-600 hover:bg-blue-500 hover:text-white text-white"
            large
            v-if="request.is_approved == null"
          >
            Approve
          </a-button>
        </div>
      </a-card>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    this.getRequestTime();
  },
  methods: {
    async getRequestTime() {
      console.log("ddfssdsffsd", this.$route.query);

      let data = await this.getTimeOffRequest(this.$route.query.id);
      this.request = data.data;
    },
    async approve(data) {
      //   this.is_approved = 1;
      this.loading = true;
      data.is_approved = 1;
      //   console.log("is approved", data);
      await this.declineOrApprove(data);
      await this.getTimeOffRequest(this.$route.query.id);
      this.loading = false;
    },
    async decline(data) {
      this.loading = true;
      console.log("is approved", data);
      data.is_approved = 0;
      await this.declineOrApprove(data);
      await this.getTimeOffRequest(this.$route.query.id);
      this.loading = false;
    },
  },
  data() {
    return {
      request: null,
      loading: false,
    };
  },
};
</script>