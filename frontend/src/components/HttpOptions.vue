<template>
  <div class="space-y-6">
    <h2>Headers</h2>
    <ul>
      <li class="text-sm">
        Content-Type: application/json
      </li>
    </ul>

    <h2>Body Request</h2>
    <span class="text-gray-500 text-sm">Path: <i>/orders</i></span>
    <div
      v-for="(data, index) in bodyRequest"
      :key="index"
      class="flex flex-col space-y-2"
    >
      <div
        v-for="(value, name) in data"
        :key="`${name}-${index}`"
        class="flex items-center justify-between"
      >
        <span>{{ name }}</span>
        <input
          v-model="bodyRequest[index][name]"
          :type="typeof value == 'number' ? 'number' : 'text'"
        > 
      </div>
    </div>

    <div class="my-8 flex justify-between">
      <button
        class="btn btn-primary w-full rounded-none"
        @click="addParams()"
      >
        Adicionar Parâmetros
      </button>
      <button
        :disabled="loading"
        class="btn btn-success w-full rounded-none"
        @click="send()"
      >
        <span v-text="loading ? 'Carregando...' : 'Enviar'" />
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import {ICreateOrder} from '@/interfaces/ICreateOrder'
import { api } from '@/service'
import axios from 'axios'
export default defineComponent({
  emits:['on-data'],
  setup(props, {emit}) {
    const dataModel: ICreateOrder = {
      ArticleCode:"",
      ArticleName:"",
      UnitPrice:0,
      Quantity: 0
    }

    const loading = ref(false);
    const bodyRequest = ref<ICreateOrder[]>([dataModel])

    const addParams = () => bodyRequest.value.push(dataModel)

    const send = async () => {
      try {
        loading.value = true
        const response = await api.post('/orders', bodyRequest.value)
          emit('on-data', response);
      } catch (error) {
        if(axios.isAxiosError(error)) {
          emit('on-data', error.response);
        }
      } finally {
        loading.value = false;
      }
    }

    return {
      loading,
      bodyRequest,
      addParams,
      send
    }
  },
})
</script>
