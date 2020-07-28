<template>
    <div>
        <router-view />
        <upgrade-plan></upgrade-plan>
        <the-trial-expired></the-trial-expired>
        <div v-if="overlay" class="overlay open"></div>
    </div>
</template>

<script>
import UpgradePlan from "@/components/plans/UpgradePlan";
import TheTrialExpired from "@/components/template/TheTrialExpired";

export default {
    data: () => {
        return {
            overlay: false
        };
    },
    components: {
        UpgradePlan,
        TheTrialExpired
    },
    mounted() {
        this.addClassNameListener();
    },
    methods: {
        addClassNameListener: function() {
            var el = document.querySelector("body");
            var lastClassName = el.className;
            window.setInterval(
                function() {
                    var className = el.className;
                    if (className !== lastClassName) {
                        if (el.className == "v-tour--active") {
                            this.overlay = true;
                        } else {
                            this.overlay = false;
                        }
                        lastClassName = className;
                    }
                }.bind(this),
                10
            );
        }
    }
};
</script>

<style>
.overlay {
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.8);
}
.overlay.open {
    position: fixed;
    z-index: 100;
    opacity: 0.6;
}
</style>
