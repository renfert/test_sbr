<template>
    <div>
        <router-view />
        <upgrade-plan></upgrade-plan>
        <the-trial-expired></the-trial-expired>
    </div>
</template>

<script>
import UpgradePlan from '@/components/plans/UpgradePlan'
import TheTrialExpired from '@/components/template/TheTrialExpired'

export default {
    components: {
        UpgradePlan,
        TheTrialExpired
    }
}
</script>

   
