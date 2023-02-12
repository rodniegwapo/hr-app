<template>
  <div>
    <div class="container">
      <div class="wrap">
        <div class="profile">
          <div class="profile__options"></div>

          <div class="avatar" id="avatar">
            <div id="preview">
              <a-spin
                size="large"
                tip="loading..."
                v-if="isSpin"
                class="spin"
              />
              <img
                src="@/assets/images/profile.png"
                id="avatars-image"
                class="avatar_img"
                v-if="imageName == null"
              />
              <img
                :src="
                  require(`../../../api/public/storage/images/${imageName}`)
                    ? require(`../../../api/public/storage/images/${imageName}`)
                    : ''
                "
                @error="$event.target.src = '@/assets/images/profile.png'"
                id="avatar-image"
                class="avatar_img"
                v-else
              />
            </div>
            <form action="" enctype="multipart/form-data">
              <div class="avatar_upload">
                <label class="upload_label"
                  >Upload
                  <input
                    type="file"
                    id="file"
                    ref="file"
                    @change="handleChange($event)"
                  />
                </label>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getImage();
  },
  updated() {
    console.log("updated");
  },
  methods: {
    async handleChange(event) {
      this.image = this.$refs.file.files[0];
      const formData = new FormData();
      formData.append("image", this.image);
      this.isSpin = true;
      await this.$axios
        .$post("/api/upload_user_image", formData)
        .then((res) => {
          setTimeout(() => {
            let item = res.image.split("/");
            this.imageName = item[2] + "/" + item[3];
            this.isSpin = false;
          }, 5000);
        })
        .catch((err) => {});
    },
    async getImage() {
      let data = await this.getImageUser();
      if (data.length != 0) {
        let item = data[0].image.split("/");
        this.imageName = item[2] + "/" + item[3];
      }
    },
  },
  data() {
    return {
      image: null,
      form: {
        form: "dfsfd",
      },
      imageName: null,
      isSpin: false,
    };
  },
};
</script>

<style scoped>
body {
  font-family: "Avenir", serif;
  background: #213;
  margin: 0;
  padding: 0;
}
.container {
  display: flex;
  align-items: center;
  padding: 0;
  margin: 0;
  flex-wrap: wrap;
}
.wrap {
  text-align: center;
}
.wrap h1 {
  color: #fff;
}
#file {
  visibility: hidden;
}
.profile {
  margin: auto;
  max-width: 400px;
  border-radius: 10px;
  position: relative;
  padding: 0 0 10px 0;
  /*   border: 1px solid #ccc; */
}
.profile__options {
  display: flex;
  flex-wrap: nowrap;
  width: 90%;
  margin: auto;
  justify-content: space-between;
  padding-bottom: 10px;
  color: #666;
}
.upload-btn {
  font-size: 13px;
  text-transform: uppercase;
  color: #888;
}
#upload_label {
  cursor: pointer;
  position: absolute;
  left: 15px;
  top: 12px;
  font-size: 14px;
}
#upload_label:hover,
#upload_label:focus {
  color: #222;
}
.last-btn,
.next-btn {
  top: 110px;
  position: relative;
  font-size: 22px;
}
.btn {
  cursor: pointer;
}
.btn:focus,
.btn:hover {
  color: rgba(44, 105, 1 51, 1);
}
.avatar {
  width: 150px;
  height: 150px;
  border-radius: 100%;
  border: 2px solid #fff;
  margin: 10px auto;
  position: relative;
  overflow: hidden;
  z-index: 2;
  transform: translateZ(0);
  transition: border-color 200ms;
}
.avatar--upload-error {
  border-color: #f73c3c;
  animation: shakeNo 300ms 1 forwards;
}
@keyframes shakeNo {
  20%,
  60% {
    transform: translateX(6px);
  }
  40%,
  80% {
    transform: translate(-6px);
  }
}
.avatar:hover .avatar_upload,
.avatar--hover .avatar_upload {
  opacity: 1;
}
.avatar:hover .upload_label,
.avatar--hover .upload_label {
  display: block;
}
#preview::after {
  content: "Loading...";
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  text-align: center;
  z-index: -1;
  line-height: 150px;
  color: #999;
}
.avatar_img--loading {
  opacity: 0;
}
.avatar_img {
  width: 100%;
  height: auto;
  animation: inPop 250ms 150ms 1 forwards
    cubic-bezier(0.175, 0.885, 0.32, 1.175);
  transform: scale(0);
  opacity: 0;
}
@keyframes inPop {
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
.avatar_img--rotate90 {
  transform: rotate(90deg);
}
.avatar_upload {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  text-align: center;
  height: 100%;
  background: #25cfe3;
  background: rgba(44, 205, 251, 0.6);
  display: flex;
  align-items: center;
  opacity: 0;
  transition: opacity 500ms;
}
.upload_label {
  color: #111;
  text-transform: uppercase;
  font-size: 14px;
  cursor: pointer;
  white-space: nowrap;
  padding: 4px;
  border-radius: 3px;
  min-width: 60px;
  width: 100%;
  max-width: 80px;
  margin: auto;
  font-weight: 400;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  background: #fff;
  animation: popDown 300ms 1 forwards;
  transform: translateY(-10px);
  opacity: 0;
  display: none;
  transition: background 200ms, color 200ms;
}
@keyframes popDown {
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}
.upload_label:hover {
  color: #fff;
  background: #222;
}
#upload {
  width: 100%;
  opacity: 0;
  height: 0;
  overflow: hidden;
  display: block;
  padding: 0;
  text-align: center;
}
.nickname {
  text-align: center;
  font-weight: 400;
  font-size: 20px;
  color: #666;
  position: relative;
}
#name:hover {
  outline: lightblue auto 5px;
  outline: -webkit-focus-ring-color auto 5px;
}
.ant-spin-spinning {
  position: absolute !important;
  z-index: 20;
  top: 53px;
  left: 43px;
}
</style>