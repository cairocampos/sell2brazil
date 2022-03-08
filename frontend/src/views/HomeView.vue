<template>
  <div class="grid grid-cols-2 gap-10">
    <HttpOptions
      class="border rounded-sm p-4"
      @on-data="response = $event"
    />
    <HttpResponse
      :raw="response"
      class="border rounded-sm p-4"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'

import HttpOptions from '@/components/HttpOptions.vue'
import HttpResponse from '@/components/HttpResponse.vue'
import { AxiosError, AxiosResponse } from 'axios';
export default defineComponent({
  components: {
    HttpOptions,
    HttpResponse
  },
  setup() {
    const response = ref<AxiosResponse>();
    return {
      response
    }
  },
})
</script>


<style lang="scss" scoped>
.content {
  border: 1px solid #DDD;
  border-radius: 4px;
}
</style>