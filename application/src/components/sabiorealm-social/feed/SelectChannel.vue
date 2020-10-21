<template>
  <el-dialog top="5vh" :visible.sync="modal" width="30%">
    <div slot="title" class="center">
      <h4>
        {{ lang['connect-to-channel'] }}
      </h4>
    </div>
    <!-- Public -->
    <div
      v-if="publicNetwork != false && publicNetwork != null"
      @click.prevent="changeChannel('public')"
    >
      <el-row class="publish-location">
        <el-col :sm="4">
          <img style="width: 50px" src="@/assets/img/social/world.png" />
        </el-col>
        <el-col :sm="20">
          <h4 class="fw-700" style="margin: 0px">{{ lang['public'] }}</h4>
          <h4 style="margin: 0px">{{ lang['anyone-can-see'] }}</h4>
        </el-col>
      </el-row>
    </div>

    <!-- Specific group -->
    <el-row class="publish-location">
      <el-col :sm="4">
        <img
          style="width: 50px"
          src="@/assets/img/general/ux/join_persons.png"
          alt=""
        />
      </el-col>
      <el-col :sm="14">
        <h4 class="m-b-20 fw-700" style="margin: 0px">
          {{ lang['specific-group'] }}
        </h4>
        <el-select
          @change="changeChannel('group')"
          v-model="select.group"
          class="m-b-20"
          filterable
          placeholder="Select"
        >
          <el-option
            v-for="(group, index) in groups"
            :key="index"
            :label="group.name"
            :value="{ id: group.id, name: group.name, type: 'group' }"
          >
          </el-option>
        </el-select>
      </el-col>
    </el-row>

    <!-- Specific course -->
    <el-row class="publish-location">
      <el-col :sm="4">
        <img
          style="width: 50px"
          src="@/assets/img/general/ux/view_course.png"
        />
      </el-col>
      <el-col :sm="14">
        <h4 class="m-b-20 fw-700" style="margin: 0px">
          {{ lang['specific-course'] }}
        </h4>
        <el-select
          @change="changeChannel('course')"
          v-model="select.course"
          class="m-b-20"
          filterable
          placeholder="Select"
        >
          <el-option
            v-for="(course, index) in courses"
            :key="index"
            :label="course.title"
            :value="{ id: course.id, name: course.title, type: 'course' }"
          >
          </el-option>
        </el-select>
      </el-col>
    </el-row>
  </el-dialog>
</template>

<script>
import { mapState } from 'vuex';
import { eventBus } from '@/components/sabiorealm-social/App';

export default {
  props: ['public-network'],
  created() {
    this.showSections();
    eventBus.$on('open-channel-modal', () => {
      this.modal = true;
    });
  },
  data: () => {
    return {
      modal: false,
      groups: [],
      courses: [],
      publicNetworkStatus: null,
      select: {
        course: '',
        gorup: ''
      }
    };
  },
  computed: {
    ...mapState(['lang', 'user'])
  },
  methods: {
    changeChannel(channelType) {
      if (channelType === 'public') {
        eventBus.$emit('connect-to-public-channel');
      } else if (channelType === 'group') {
        eventBus.$emit('connect-to-group-channel', this.select.group);
      } else {
        eventBus.$emit('connect-to-course-channel', this.select.course);
      }
      this.modal = false;
      this.select.group = '';
      this.select.course = '';
    },
    showSections() {
      this.$request
        .get(this.$getUrlToMakeRequest('SocialNetwork', 'listingGroups'))
        .then((response) => {
          this.groups = response.data;
        });
      this.$request
        .get(this.$getUrlToMakeRequest('SocialNetwork', 'listingCourses'))
        .then((response) => {
          this.courses = response.data;
        });
      this.dialogVisible = true;
    }
  }
};
</script>

<style scoped>
.box-card {
  border-radius: 30px;
  padding: 4%;
}

.publish-location {
  display: flex;
  align-items: center;
  margin: 0px;
  margin-bottom: 5%;
  padding: 3%;
  border-radius: 20px;
  box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.publish-location:hover {
  background-color: #f8f8ff;
}

.publication_area {
  display: inline-block;
  padding: 0% 5% 0% 5%;
  border: 1px solid #e4e4e4 !important;
  width: 100% !important;
  border-radius: 14px !important;
  overflow-y: auto;
  overflow-x: hidden;
  height: 250px !important;
  border-radius: 14px !important;
  border: 2px solid #ccc;
  -webkit-transition: border-color 0.15s linear !important;
  transition: border-color 0.15s linear !important;
}

.publication_area textarea {
  border: none;
  resize: none;
  width: 100%;
  color: #647b9c;
  font-family: 'Poppins', sans-serif !important;
  font-size: 15px !important;
  height: auto;
  box-sizing: border-box;
  display: block;
}

.widget_publication:hover {
  transform: translateY(-1px);
  cursor: pointer;
}

.preview_img {
  border-style: none;
  margin-bottom: 10%;
  height: auto;
  width: 90%;
  object-fit: cover;
  border-radius: 20px;
}

.img_wrp {
  display: inline-block;
  position: relative;
}
.close_icon {
  position: absolute;
  top: 0;
  right: 0;
  cursor: pointer;
  opacity: 0.8;
  width: 10%;
  right: 5%;
}

.close_icon:hover {
  opacity: 1;
}
</style>
