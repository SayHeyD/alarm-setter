<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
          <div class="flex flex-col md:flex-row md:justify-between border-b pb-4 border-gray-200">
            <div>
              <h3 class="text-2xl font-semibold">Aktuelle Temparatur</h3>
              <div class="text-xl">
                <p v-if="CurrentTemp !== null" v-text="CurrentTemp"></p>
                <p v-else class="text-red-500">Keine aktuellen Daten vorhanden!</p>
              </div>
            </div>

            <div>
              <h3 class="text-2xl font-semibold">Unteres Temparaturlimit</h3>
              <div class="text-xl">
                <p v-if="bottomLimit !== null" v-text="bottomLimit"></p>
                <p v-else class="text-red-500">Kein Limit gesetzt!</p>
              </div>
            </div>

            <div>
              <h3 class="text-2xl font-semibold">Oberes Temparaturlimit</h3>
              <div class="text-xl">
                <p v-if="topLimit !== null" v-text="topLimit"></p>
                <p v-else class="text-red-500">Kein Limit gesetzt!</p>
              </div>
            </div>
          </div>

          <div class="mt-8">
            <form @submit.prevent="submit" class="flex flex-col">
              <div class="w-full mb-4">
                <label for="topLimit">Oberes Limit</label>
                <input id="topLimit" class="p-2 border-2 border-indigo-500 rounded w-full" type="number" step="0.1" v-model="form.topLimit">
              </div>

              <div class="w-full">
                <label for="bottomLimit">Unteres Limit</label>
                <input id="bottomLimit" class="p-2 border-2 border-indigo-500 rounded w-full" type="number" step="0.1" v-model="form.bottomLimit">
              </div>

              <button type="submit" class="mt-6 bg-indigo-400 hover:bg-indigo-500 hover:underline p-2 text-white rounded-sm md:mx-auto md:w-1/3">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import {Inertia} from '@inertiajs/inertia'

export default {
    props: {
        CurrentTemp: {
            Type: Number,
            Default: null,
        },
        topLimit: {
            Type: Number,
            Default: null,
        },
        bottomLimit: {
            Type: Number,
            Default: null,
        }
    },
    data() {
        return {
            form: {
                topLimit: null,
                bottomLimit: null,
            }
        }
    },
    components: {
        AppLayout,
    },
    mounted() {
        this.form.topLimit = this.topLimit;
        this.form.bottomLimit = this.bottomLimit;
    },
    created() {
        setInterval(() => this.refreshProps(), 10000);
    },
    methods: {
        refreshProps() {
            Inertia.reload({
                only: [
                    'CurrentTemp',
                    'topLimit',
                    'bottomLimit'
                ]
            })
        },
        submit() {
            this.$inertia.post(route('api_set_limits'), this.form, {
                onFinish: () => {
                    this.refreshProps();
                }
            })

        }
    }
}
</script>
