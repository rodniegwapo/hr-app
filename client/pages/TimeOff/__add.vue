<template>
  <div>
    <a-card ref="page">
      <ValidationObserver ref="observer" tag="form">
        <ValidationProvider name="Type" rules="required" v-slot="{ errors }">
          <div><label for="">Select Time-off Type </label></div>

          <a-select ref="select" v-model="form.type" class="w-full">
            <a-select-option
              :value="type.id"
              v-for="(type, key) in types"
              :key="key"
              >{{ type.name }}</a-select-option
            >
          </a-select>
          <span class="error">{{ errors[0] }}</span>
        </ValidationProvider>
        <div class="pt-4">
          <ValidationProvider
            name="Start Date    "
            rules="required"
            v-slot="{ errors }"
          >
            <div><label for="">Select Start Date</label></div>
            <a-date-picker
              placeholder="Select Time"
              show-time
              format="YYYY-MM-DD HH:mm:ss"
              v-model="form.startDate"
              class="w-full"
            />
            <span class="error">{{ errors[0] }}</span>
          </ValidationProvider>
          <div class="pt-4">
            <ValidationProvider
              name="End Date"
              rules="required"
              v-slot="{ errors }"
            >
              <div><label for="">Select End Date</label></div>
              <a-date-picker
                placeholder="Select Time"
                show-time
                format="YYYY-MM-DD HH:mm:ss"
                v-model="form.endDate"
                class="w-full"
              />

              <span class="error">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>
          <div class="pt-4">
            <ValidationProvider name="notes">
              <div><label for="">Notes</label></div>
              <a-textarea
                v-model="form.notes"
                placeholder="Notes"
                allow-clear
              />
            </ValidationProvider>
          </div>
          <div class="pt-4 flex w-full justify-end">
            <a-button
              class="bg-blue-600 text-white"
              :loading="loading"
              @click="AddRequest"
            >
              Submit
            </a-button>
          </div>
        </div>
      </ValidationObserver>
    </a-card>
  </div>
</template>

<script>
export default {
  created() {
    this.allTypes();
  },
  watch: {
    "form.startDate": {
      handler(val) {
        if (this.form.endDate != null) {
          let end = this.$moment(this.form.endDate).format(
            "YYYY/MM/DD h:mm:ss"
          );
          let start = this.$moment(val).format("YYYY/MM/DD h:mm:ss");
          if (start > end) {
            this.form.startDate = end;
            this.form.endDate = start;
          }
        }
      },
    },
    "form.endDate": {
      handler(val) {
        if (this.form.startDate != null) {
          let start = this.$moment(this.form.startDate).format(
            "YYYY/MM/DD h:mm:ss"
          );
          let end = this.$moment(val).format("YYYY/MM/DD h:mm:ss");
          if (start > end) {
            this.form.startDate = end;
            return (this.form.endDate = start);
          }
        }
        console.log("end date");
      },
    },
  },
  methods: {
    async allTypes() {
      let data = await this.getTypes();
      this.types = data.data;
      console.log("tyess", this.types);
    },
    async AddRequest() {
      let isValid = await this.$refs.observer.validate();
      if (isValid) {
        this.form.startDate = this.$moment(this.form.startDate).format(
          "YYYY/MM/DD h:mm:ss"
        );
        this.form.endDate = this.$moment(this.form.endDate).format(
          "YYYY/MM/DD h:mm:ss"
        );
        this.loading = true;
        await this.saveTimeOff(this.form)
          .then((res) => {
            console.log(res);
            this.$nuxt.$emit("saveTimeOff");
            this.$message.success("Successfully created");
          })
          .catch((e) => {
            console.log(e);
          });
        this.loading = false;
        this.$nuxt.$emit("saveTimeOff");
        this.$refs.page.$forceUpdate();
        this.$refs.observer.reset();
        this.reset();
      }
    },
    reset() {
      this.form = {
        startDate: null,
        endDate: null,
        type: null,
      };
    },
  },
  data() {
    return {
      form: {
        startDate: null,
        endDate: null,
      },
      loading: false,
      types: null,
    };
  },
};
</script>