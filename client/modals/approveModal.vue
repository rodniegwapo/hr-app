<template>
  <div>
    <a-modal @cancel="close" v-model="visible" title="Time off request">
      <div>Name: {{ info.user.firstname + " " + info.user.lastname }}</div>
      <div class="pt-2">Type: {{ info.type.name }}</div>
      <div class="pt-2">Start date: {{ info.start_date }}</div>
      <div class="pt-2">End date: {{ info.end_date }}</div>
      <div class="pt-2">Notes: {{ info.notes }}</div>
      <div class="pt-2">
        Status:

        <a-tag v-if="info.is_approved == null" color="orange">Pending</a-tag>
        <a-tag v-if="info.is_approved == 1" color="green">Approved</a-tag>
        <a-tag v-if="info.is_approved == 0" color="red">Declined</a-tag>
        <a-tag v-if="info.is_approved == 3" color="red">Cancelled</a-tag>
      </div>
      <template slot="footer" class="px-4">
        <div>
          <a-button @click="close" v-if="info.is_approved != null" class="">
            Back
          </a-button>
          <a-button
            v-if="info.is_approved == null"
            class="bg-red-600 hover:bg-red-500 text-white"
            :loading="loading"
            @click="decline(info)"
          >
            Decline
          </a-button>
          <a-button
            v-if="info.is_approved == null"
            class="bg-blue-600 hover:bg-blue-500 text-white"
            :loading="loading"
            @click="approve(info)"
          >
            Approve
          </a-button>
        </div>
      </template>
    </a-modal>
  </div>
</template>
<script>
export default {
  props: {
    info: {
      type: Object,
      default: () => {},
    },
  },
  methods: {
    close() {
      console.log("clsoe");
      this.$nuxt.$emit("close", null);
    },
    handleOk() {
      console.log("oks");
    },
    async approve(info) {
      this.loading = true;
      let data = { ...info };
      data.is_approved = 1;
      data.id = data.primary_id;
      await this.declineOrApprove(data);
      this.$nuxt.$emit("allTimeOffs");
      this.$nuxt.$emit("close");
      this.loading = false;
    },
    async decline(info) {
      this.loading = true;
      let data = { ...info };
      data.is_approved = 0;
      data.id = data.primary_id;
      await this.declineOrApprove(data);
      this.$nuxt.$emit("allTimeOffs");
      this.$nuxt.$emit("close");
      this.loading = false;
    },
  },
  data() {
    return {
      visible: true,
      loading: false,
    };
  },
};
</script>