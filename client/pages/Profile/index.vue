<template>
  <div>
    <div class="container mx-auto">
      <div class="md:flex no-wrap md:-mx-2">
        <!-- Left Side -->
        <div class="w-full md:w-3/12 md:mx-2">
          <!-- Profile Card -->
          <div class="bg-white p-3 border-t-4 border-blue-600">
            <div class="image overflow-hidden">
              <img
                class="h-auto w-full mx-auto"
                src="@/assets/images/profile.png"
                alt=""
              />
            </div>

            <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">
              {{ manager }}
              {{
                capitalize(
                  this.userDetails ? this.userDetails.auth[0].firstname : ""
                ) +
                " " +
                capitalize(
                  this.userDetails ? this.userDetails.auth[0].lastname : ""
                )
              }}
            </h1>
            <p class="text-sm text-gray-500 hover:text-gray-600 leading-6">
              <span class="text-lg"
                >Position:
                {{
                  userDetails ? userDetails.auth[0]["roles"][0].name : ""
                }}</span
              >
            </p>
            <p
              v-if="userDetails && userDetails.manager"
              class="text-sm text-gray-500 hover:text-gray-600 leading-6"
            >
              <span class="text-md">Manager: </span
              >{{
                userDetails.manager[0].firstname +
                " " +
                userDetails.manager[0].lastname
              }}
            </p>
            <ul
              class="
                bg-gray-100
                text-gray-600
                hover:text-gray-700 hover:shadow
                py-2
                px-3
                mt-3
                divide-y
                rounded
                shadow-sm
              "
            >
              <li class="flex items-center py-3">
                <span>Status</span>
                <span class="ml-auto"
                  ><span
                    class="bg-blue-600 py-1 px-2 rounded text-white text-sm"
                    >Active</span
                  ></span
                >
              </li>
              <li class="flex items-center py-3">
                <span>Member since</span>
                <span class="ml-auto">Feb 13, 2022</span>
              </li>
            </ul>
          </div>
          <!-- End of profile card -->
          <div class="my-4"></div>
          <!-- Friends card -->
          <!-- End of friends card -->
        </div>
        <!-- Right Side -->
        <div class="w-full md:w-9/12 mx-2 h-64">
          <!-- Profile tab -->
          <!-- About Section -->
          <div class="bg-white p-3 shadow-sm rounded-sm">
            <div
              class="
                flex
                items-center
                space-x-2
                font-semibold
                text-gray-900
                leading-8
              "
            >
              <span clas="text-green-500">
                <svg
                  class="h-5"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  />
                </svg>
              </span>
              <span class="tracking-wide">About</span>
            </div>
            <div class="text-gray-700">
              <div class="grid md:grid-cols-2 text-sm">
                <div class="grid grid-cols-2">
                  <div class="px-4 py-2 font-semibold">First Name</div>
                  <div class="px-4 py-2" v-if="userDetails">
                    {{
                      capitalize(
                        this.userDetails
                          ? this.userDetails.auth[0].firstname
                          : ""
                      )
                    }}
                  </div>
                </div>
                <div class="grid grid-cols-2">
                  <div class="px-4 py-2 font-semibold">Last Name</div>
                  <div class="px-4 py-2">
                    {{
                      capitalize(
                        this.userDetails
                          ? this.userDetails.auth[0].lastname
                          : ""
                      )
                    }}
                  </div>
                </div>
                <div class="grid grid-cols-2">
                  <div class="px-4 py-2 font-semibold">Gender</div>
                  <div class="px-4 py-2">Female</div>
                </div>
                <div class="grid grid-cols-2">
                  <div class="px-4 py-2 font-semibold">Contact No.</div>
                  <div class="px-4 py-2">+11 998001001</div>
                </div>
                <div class="grid grid-cols-2">
                  <div class="px-4 py-2 font-semibold">Current Address</div>
                  <div class="px-4 py-2">Beech Creek, PA, Pennsylvania</div>
                </div>
                <div class="grid grid-cols-2">
                  <div class="px-4 py-2 font-semibold">Permanant Address</div>
                  <div class="px-4 py-2">Arlington Heights, IL, Illinois</div>
                </div>
                <div class="grid grid-cols-2">
                  <div class="px-4 py-2 font-semibold">Email.</div>
                  <div class="px-4 py-2">
                    <a
                      class="text-blue-800"
                      :href="`mailto:${
                        userDetails ? this.userDetails.auth[0].email : ''
                      }`"
                      >{{
                        capitalize(
                          this.userDetails ? this.userDetails.auth[0].email : ""
                        )
                      }}</a
                    >
                  </div>
                </div>
                <div class="grid grid-cols-2">
                  <div class="px-4 py-2 font-semibold">Birthday</div>
                  <div class="px-4 py-2">Feb 06, 1998</div>
                </div>
              </div>
            </div>
            <button
              class="
                block
                w-full
                text-blue-800 text-sm
                font-semibold
                rounded-lg
                hover:bg-gray-100
                focus:outline-none focus:shadow-outline focus:bg-gray-100
                hover:shadow-xs
                p-3
                my-4
              "
            >
              Show Full Information
            </button>
          </div>
          <!-- End of about section -->

          <div class="my-4"></div>

          <!-- Experience and education -->
          <div
            class="bg-white p-3 shadow-sm rounded-sm"
            v-if="userDetails && userDetails.staff ? true : false"
          >
            <div class="grid grid-cols-2">
              <div>
                <div
                  class="
                    flex
                    items-center
                    space-x-2
                    font-semibold
                    text-gray-900
                    leading-8
                    mb-3
                  "
                >
                  <span clas="text-green-500">
                    <svg
                      class="h-5"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      />
                    </svg>
                  </span>
                  <span class="tracking-wide">Staff</span>
                  <div></div>
                </div>
              </div>
            </div>

            <a-table
              bordered
              :data-source="
                userDetails && userDetails.staff ? userDetails.staff : staff
              "
              :columns="columns"
              :loading="loading"
            >
            </a-table>
            <!-- End of Experience and education grid -->
          </div>
          <!-- End of profile tab -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  created() {
    this.getUserInfo();
  },
  mounted() {},
  computed: {
    ...mapState("todo", {
      userDetails: (state) => state.userDetails,
    }),
  },

  watch: {},
  methods: {
    async getUserInfo() {
      if (process.client) {
        if (this.userDetails == null) {
          let item = JSON.parse(localStorage.getItem("selectedUser"));
          let data = await this.getUserDetails(item);
          this.$store.commit("todo/setUserDetails", data);
        }
      }
    },
  },
  data() {
    return {
      staff: null,
      manager:
        this.userDetails && this.userDetails.manager
          ? this.userDetails.manager
          : null,
      employee: this.userDetails,
      columns: [
        {
          title: "First name",
          dataIndex: "firstname",
          scopedSlots: { customRender: "name" },
        },
        { title: "Last Name", dataIndex: "lastname" },
        { title: "Email Adress", dataIndex: "email", width: "30%" },
        { title: "Role", dataIndex: "roles[0].name" },
      ],
    };
  },
};
</script>