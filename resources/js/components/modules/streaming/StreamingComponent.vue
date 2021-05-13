<template>
<!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Streaming
                <span class="d-block text-muted pt-2 font-size-sm">{{ __('Employee administration') }}</span></h3>
            </div>
            <div class="card-toolbar">

            </div>
        </div>


        <div class="card-body">

            <div class="form-row pl-3 align-items-end">

                <div class="col-sm-6 col-lg-4 form-group">
                    <label style="text-transform: uppercase;"><b>{{ __('validation.attributes.dprofile_office') }}</b></label>
                    <vs-select :key="offices.length" filter v-model="searches.office" :placeholder="__('Select')">
                        <vs-option v-for="office in offices" :key="office.id" :label="office.name" :value="office.id">{{ office.name }}</vs-option>
                    </vs-select>
                </div>

                <div class="col-sm-6 col-lg-4 form-group">
                    <label for="name" style="text-transform: uppercase;"><b>{{ __('validation.attributes.name') }}</b></label>
                    <input v-model="searches.name" type="text" class="form-control" name="name" :placeholder="__('validation.attributes.name')">
                </div>

                <div class="col-10 col-sm-5 col-lg-3 form-group">
                    <label for="declarant" style="text-transform: uppercase;"><b>declarante</b></label>
                    <input v-model="searches.declarant" type="text" class="form-control" name="declarant" placeholder="nif, email, nombre, teléfono">
                </div>

                <div class="col-auto form-group">

                    <vs-tooltip top>
                        <button @click="clearSearches" type="button"
                            class="btn waves-effect waves-light btn-danger float-right font-weight-bolder">
                            <i class="fas fa-filter"></i>
                        </button>
                        <template #tooltip>
                            {{ __('Remove Filters') }}
                        </template>
                    </vs-tooltip>
                </div>
            </div>

            <div v-if="ceremonies.data.length" class="table-responsive">
                <!-- <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Web</th>
                            <th>Sala</th>
                            <th class="text-nowrap d-flex justify-content-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(ceremony, index) in ceremonies.data" :key="index">
                            <td>{{ ceremony.start }} - {{ ceremony.end }}</td>
                            <td>{{ ceremony.start }}</td>
                            <td>{{ ceremony.room_name }}</td>
                            <td>
                                <div class="d-flex justify-content-center">


                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table> -->

                <vs-table >
                    <template #thead>
                        <vs-tr>
                            <vs-th>Fecha</vs-th>
                            <vs-th>Web</vs-th>
                            <vs-th>
                                {{ __('Actions') }}
                            </vs-th>
                        </vs-tr>
                    </template>
                    <template #tbody>
                    <vs-tr :key="index" v-for="(ceremony, index) in ceremonies.data">
                        <vs-td>{{ ceremony.start }} - {{ ceremony.end }}</vs-td>
                        <vs-td></vs-td>
                        <vs-td>
                            <div>
                                 <button class="btn btn-sm btn-clean btn-icon mr-2 text-success">
                                    <vs-tooltip bottom>
                                        <i class="fas fa-video"></i>
                                        <template #tooltip>
                                            Ver streaming
                                        </template>
                                    </vs-tooltip>
                                </button>

                                <button class="btn btn-sm btn-clean btn-icon mr-2 text-success" @click="openModalAddEditShow(ceremony)">
                                    <vs-tooltip bottom>
                                        <i class="fas fa-cogs"></i>
                                        <template #tooltip>
                                            Configurar streaming
                                        </template>
                                    </vs-tooltip>
                                </button>

                            </div>

                        </vs-td>

                        <template #expand>
                        <div class="con-content">
                            <div>

                            </div>
                        </div>
                        </template>
                    </vs-tr>
                    </template>
                </vs-table>

                <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="ceremonies" @pagination-change-page="getCeremonies"></pagination>
            </div>
            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                {{ __('There is no item to display') }}
            </div>

        </div>

        <streaming-form-add-edit ref="streamingFormAddEdit" @updateStreamingList="updateList()"></streaming-form-add-edit>

    </div>
<!--end::Card-->
</template>

<script>
import StreamingFormAddEdit from './StreamingFormAddEditComponent';

export default {

    components: {StreamingFormAddEdit},

    created() {
        this.getOffices()
        this.getCeremonies();
    },

    data() {
        return {

            ceremonies: {data:[]},
            offices: [],

            searches: {
                office: '',
                name: '',
                declarant: ''
            },
        }
    },

    methods: {
        getCeremonies(page = 1) {
            const url = `admin/ajax/streaming/paginate?page=${page}`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.get(url, {
                params: this.searches
            }).then(res => {
                loading.close();
                this.ceremonies = res.data.data;
            })
            .catch(err => {
                loading.close();
                console.error(err);
            })
        },

        getOffices() {
            const url = `/admin/ajax/offices`;

            axios.get(url)
            .then(res => {
                this.offices = res.data.data;
            })
            .catch(err => {
                console.error(err);
            })
        },

        clearSearches() {
            this.searches = {
                office: '',
                name: '',
                declarant: ''
            };
        },

        openModalAddEditShow(ceremony) {
            this.$refs.streamingFormAddEdit.showForm(ceremony);
        },

        updateList(action = null) {
            this.getCeremonies(this.ceremonies.current_page ?? 1 );
        },
    },

}
</script>

<style>
.vs-table__th__content {
    font-size: 1rem !important;
}
.vs-table__td {
    font-size: 12px !important;
}
.btn.btn-clean:hover:not(.btn-text):not(:disabled):not(.disabled) {
    background-color: #EE2D41 !important;
    color: #ffffff !important;
}
</style>
