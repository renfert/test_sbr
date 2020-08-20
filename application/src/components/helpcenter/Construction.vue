  <template>
  <div class="mt-5 text-center pr-5 pl-5">
    <img class="no-results-img" src="@/assets/img/general/ux/no_persons.png" alt="No courses" />
    <h4 class="no-results-text">{{lang["under-construction-title"]}}</h4>
    <p>{{lang["under-construction-subtitle"]}}</p>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState(["lang"])
  }
};
</script>


