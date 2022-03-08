<template>
  <AppHeader />
  <main class="container mx-auto my-8">
    <router-view v-slot="{ Component, route }">
      <transition
        name="slide"
        mode="out-in"
      >
        <component
          :is="Component"
          :key="route.path"
        />
      </transition>
    </router-view>
  </main>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import AppHeader from '@/components/layout/AppHeader.vue'

export default defineComponent({
  components: {
    AppHeader
  }
})
</script>


<style lang="scss">
.slide-enter-from,
.slide-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}

.slide-leave-to {
  transform: translateX(20px);
}

.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s;
}
</style>
