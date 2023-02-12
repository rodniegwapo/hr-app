
<template>
  <div>
    <approve :info="info" v-if="info" />
    <div>
      <FullCalendar ref="calendar" :options="calendarOptions"> </FullCalendar>
    </div>
  </div>
</template>

<script>
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import timeGridPlugin from "@fullcalendar/timegrid";
import approve from "@/modals/approveModal";
export default {
  components: {
    FullCalendar, // make the <FullCalendar> tag available
    approve,
  },
  created() {
    this.allTimeOffs();
  },
  mounted() {
    this.$nuxt.$on("close", (data) => {
      this.info = data;
      console.log("dfsdsffsdds");
    });
    this.$nuxt.$on("allTimeOffs", () => {
      this.allTimeOffs();
    });
  },
  computed: {
    listOfEvents() {
      return this.events;
    },
  },
  methods: {
    handleDateClick(e) {
      console.log(e);
    },
    handleSelect(e) {
      console.log(e);
    },
    async allTimeOffs() {
      let data = null;
      if (this.$store.state.auth.user.roles[0].name == "Manager") {
        data = await this.getManagerTimeOffFromStaff();
      } else {
        data = await this.getApprovedTimeOffs();
      }
      let event = [];
      data.data.forEach((data) => {
        data.title = data.user.firstname + " " + data.user.lastname;
        data.description = data.notes;
        data.classNames =
          data.is_approved == null
            ? "pending"
            : data.is_approved == 0
            ? "declined"
            : "";
        data.textColor =
          data.is_approved == null
            ? "#fa8c16"
            : data.is_approved == 0
            ? "#f5222d"
            : "";
        data.primary_id = data.id;
        data.start = new Date(data.start_date).toISOString();
        data.end = new Date(data.end_date).toISOString();
        data.start_date = "";
        data.end_date = "";
        event.push(data);
      });
      this.$store.commit("todo/setEvents", event);
      this.calendarOptions.events = event;
    },
    showInfo(data) {
      this.info = data;
      console.log(this.info);
    },
  },
  data() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: ["dayGridMonth"],
        selectable: true,
        eventClick: (info) => {
          this.showInfo(info.event._def.extendedProps);
        },
        events: this.$store.state.todo.events,
      },
      info: null,
    };
  },
};
</script>
<style>
.popper,
.tooltip {
  position: absolute;
  z-index: 9999;
  background: #ffc107;
  color: black;
  width: 150px;
  border-radius: 3px;
  box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
  padding: 10px;
  text-align: center;
}
.style5 .tooltip {
  background: #1e252b;
  color: #ffffff;
  max-width: 200px;
  width: auto;
  font-size: 0.8rem;
  padding: 0.5em 1em;
}
.popper .popper__arrow,
.tooltip .tooltip-arrow {
  width: 0;
  height: 0;
  border-style: solid;
  position: absolute;
  margin: 5px;
}

.tooltip .tooltip-arrow,
.popper .popper__arrow {
  border-color: #ffc107;
}
.style5 .tooltip .tooltip-arrow {
  border-color: #1e252b;
}
.popper[x-placement^="top"],
.tooltip[x-placement^="top"] {
  margin-bottom: 5px;
}
.popper[x-placement^="top"] .popper__arrow,
.tooltip[x-placement^="top"] .tooltip-arrow {
  border-width: 5px 5px 0 5px;
  border-left-color: transparent;
  border-right-color: transparent;
  border-bottom-color: transparent;
  bottom: -5px;
  left: calc(50% - 5px);
  margin-top: 0;
  margin-bottom: 0;
}
.popper[x-placement^="bottom"],
.tooltip[x-placement^="bottom"] {
  margin-top: 5px;
}
.tooltip[x-placement^="bottom"] .tooltip-arrow,
.popper[x-placement^="bottom"] .popper__arrow {
  border-width: 0 5px 5px 5px;
  border-left-color: transparent;
  border-right-color: transparent;
  border-top-color: transparent;
  top: -5px;
  left: calc(50% - 5px);
  margin-top: 0;
  margin-bottom: 0;
}
.tooltip[x-placement^="right"],
.popper[x-placement^="right"] {
  margin-left: 5px;
}
.popper[x-placement^="right"] .popper__arrow,
.tooltip[x-placement^="right"] .tooltip-arrow {
  border-width: 5px 5px 5px 0;
  border-left-color: transparent;
  border-top-color: transparent;
  border-bottom-color: transparent;
  left: -5px;
  top: calc(50% - 5px);
  margin-left: 0;
  margin-right: 0;
}
.popper[x-placement^="left"],
.tooltip[x-placement^="left"] {
  margin-right: 5px;
}
.popper[x-placement^="left"] .popper__arrow,
.tooltip[x-placement^="left"] .tooltip-arrow {
  border-width: 5px 0 5px 5px;
  border-top-color: transparent;
  border-right-color: transparent;
  border-bottom-color: transparent;
  right: -5px;
  top: calc(50% - 5px);
  margin-left: 0;
  margin-right: 0;
}
.pending {
  background: #fff7e6;
  border-color: #ffd591;
}
.declined {
  background: #fff1f0;
  border-color: #ffa39e;
}
</style>