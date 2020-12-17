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
                <p v-if="CurrentTemp !== null" :class="{'text-red-500' : CurrentTemp >= topLimit || CurrentTemp <= bottomLimit}" v-text="CurrentTemp"></p>
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
              <div v-if="$page.flash.success && showSuccessMessage" class="relative flex justify-center p-2 text-sm text-center font-semibold bg-green-400 text-white rounded mb-4">
                <p v-text="$page.flash.success"></p>
                <button @click="showSuccessMessage = false" class="hover:cursor-pointer absolute right-0 my w-4 h-4 mr-4">
                  <svg focusable="false" data-prefix="fas" data-icon="times" class="h-4 w-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
                </button>
              </div>
              <div class="w-full mb-4">
                <label for="topLimit">Oberes Limit</label>
                <input id="topLimit" class="p-2 border-2 border-indigo-500 rounded w-full" type="number" step="0.1" v-model="form.topLimit">
                <div v-if="formErrors.topLimit" class="mt-4 p-2 text-sm text-center font-semibold bg-red-500 text-white rounded mb-4">
                  <p v-text="formErrors.topLimit"></p>
                </div>
              </div>

              <div class="w-full">
                <label for="bottomLimit">Unteres Limit</label>
                <input id="bottomLimit" class="p-2 border-2 border-indigo-500 rounded w-full" type="number" step="0.1" v-model="form.bottomLimit">
                <div v-if="formErrors.bottomLimit" class="mt-4 p-2 text-sm text-center font-semibold bg-red-500 text-white rounded mb-4">
                  <p v-text="formErrors.bottomLimit"></p>
                </div>
              </div>

              <button type="submit" class="mt-6 bg-indigo-400 hover:bg-indigo-500 hover:underline p-2 text-white rounded md:mx-auto md:w-1/3">Submit</button>
            </form>
          </div>
        </div>

        <div class="mt-8 bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
          <table class="w-full">
            <thead class="bg-gray-800 text-white font-semibold text-xl">
              <tr>
                <th>Temp.</th>
                <th>Oberes Limit</th>
                <th>Unteres Limit</th>
                <th>Wann</th>
                <th>Gerät</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="lastEntries.length === 0">
                <td colspan="5">Keine Einträge gefunden</td>
              </tr>
              <tr v-else v-for="entry in lastEntries" class="odd:bg-gray-200">
                <td class="text-center py-2" v-text="entry.recorded"></td>
                <td class="text-center py-2" v-text="entry.topLimit"></td>
                <td class="text-center py-2" v-text="entry.bottomLimit"></td>
                <td class="text-center py-2" v-text="entry.recorded_at"></td>
                <td class="text-center py-2" v-text="entry.device.device_id"></td>
              </tr>
            </tbody>
          </table>
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
        },
        settingsTopLimit: {
            Type: Number,
            Default: 0.0,
        },
        settingsBottomLimit: {
            Type: Number,
            Default: 0.0,
        },
        lastEntries: {
            Type: Array,
            Default: null,
        },
        errors: null,
    },
    data() {
        return {
            form: {
                topLimit: null,
                bottomLimit: null,
            },
            formErrors: {},
            showSuccessMessage: false,
        }
    },
    components: {
        AppLayout,
    },
    mounted() {
        this.form.topLimit = this.settingsTopLimit;
        this.form.bottomLimit = this.settingsBottomLimit;
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
                    'bottomLimit',
                    'settingsTopLimit',
                    'settingsBottomLimit',
                    'lastEntries',
                ],
                preserveScroll: true,
            })
        },
        submit() {
            this.$inertia.post(route('set_limits'), this.form, {
                onFinish: () => {
                    this.formErrors = this.errors
                    this.showSuccessMessage = true
                    this.refreshProps();
                }
            })
        }
    }
}
</script>
