<template>
  <div>
    <div v-if="raw">
      <ul class="text-gray-500">
        <li>
          Status Code:
          <span
            class="text-white p-1"
            :class="getStatusCodeColor(raw.status)"
          >{{ raw.status }}</span>
        </li>
      </ul>
      <pre v-html="getDataJson" />
    </div>
    <span
      v-else
      class="text-gray-400 text-sm"
    >
      Your Response is Here
    </span>
  </div>
</template>

<script lang="ts">
import { AxiosResponse } from 'axios'
import { computed, defineComponent, PropType } from 'vue'

import useJsonPretty from '@/composables/useJsonPretty'

export default defineComponent({
  props: {
    raw: {
      type: Object as PropType<AxiosResponse>,
      required:true
    }
  },
  setup(props) {
    const getStatusCodeColor = (status: number) => {
      if(/^2/.test(String(status))) {
        return 'bg-green-500';
      }

      if(/^4/.test(String(status))) {
        return 'bg-orange-500';
      }

      return 'bg-red-500';

    }

    const getDataJson = computed(() => {
      const {pattern, replacer} = useJsonPretty();
      return JSON.stringify(props.raw.data, undefined, 2)
            .replace(/&/g, '&amp;').replace(/\\"/g, '&quot;')
             .replace(/</g, '&lt;').replace(/>/g, '&gt;')
             .replace(pattern, replacer);
    })

    return {
      getStatusCodeColor,
      getDataJson
    }
  },
})
</script>

<style lang="scss" scoped>

</style>
