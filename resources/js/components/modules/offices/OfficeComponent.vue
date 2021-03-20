<template>
<!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">{{ __('Branch Offices') }}
                <span class="d-block text-muted pt-2 font-size-sm">{{ __('Office administration') }}</span></h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <button @click="openModalAddEdit('add')" class="btn btn-primary font-weight-bolder">
                    <i class="fas fa-plus-square"></i> {{ __('Add') }}
                </button>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">

            <div class="form-row pl-3 align-items-end">

                <div class="col-sm-5 form-group">
                    <label for="name" style="text-transform: uppercase;"><b>{{ __('validation.attributes.name') }}</b></label>
                    <input v-model="searches.name" type="text" class="form-control" name="name" :placeholder="__('validation.attributes.name')">
                </div>

                <div class="col-10 col-sm-5 form-group">
                    <label for="email" style="text-transform: uppercase;"><b>{{ __('validation.attributes.address') }}</b></label>
                    <input v-model="searches.address" type="text" class="form-control" name="email" :placeholder="__('validation.attributes.address')">
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

            <div v-if="offices.data.length" class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CIF</th>
                            <th>{{ __('validation.attributes.name') }}</th>
                            <th>{{ __('validation.attributes.address') }}</th>
                            <th>{{ __('validation.attributes.email') }}</th>
                            <th>{{ __('validation.attributes.phone') }}</th>
                            <th>{{ __('validation.attributes.contact_person') }}</th>
                            <th class="text-nowrap d-flex justify-content-center">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(office, index) in offices.data" :key="index">
                            <th>{{ index + 1 }}</th>
                            <td>{{ office.cif }}</td>
                            <td>{{ office.name }}</td>
                            <td>{{ office.address }}</td>
                            <td>{{ office.email }}</td>
                            <td>{{ office.phone }}</td>
                            <td>{{ office.contact_person }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <vs-tooltip bottom>
                                        <button  class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEditShow('show', employee)">
                                            <i class="far fa-eye"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Show') }}
                                        </template>
                                    </vs-tooltip>
                                    <vs-tooltip bottom>
                                        <button class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEditShow('edit', employee)">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Edit') }}
                                        </template>
                                    </vs-tooltip>
                                    <vs-tooltip bottom>
                                        <button class="btn btn-sm btn-clean btn-icon mr-2" @click="askDestroy(employee)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <template #tooltip>
                                            {{ __('Delete') }}
                                        </template>
                                    </vs-tooltip>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="offices" @pagination-change-page="getOffices"></pagination>
            </div>
            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                {{ __('There is no item to display') }}
            </div>

        </div>

        <office-form-add-edit ref="officeFormAddEdit" @updateOfficeList="updateList()"></office-form-add-edit>

    </div>
<!--end::Card-->
</template>

<script>
import OfficeFormAddEdit from './OfficeFormAddEditComponent';

export default {
    components: {OfficeFormAddEdit},

    created() {
        this.getOffices();
    },

    watch: {
        'searches.name': function (newValue, oldValue) {
            this.getOffices();
        },
        'searches.address': function (newValue, oldValue) {
            this.getOffices();
        }
    },

    data() {
        return {
            offices: {data:[]},

            searches: {
                name: '',
                address: ''
            },
        }
    },

    methods: {
        getOffices(page = 1) {
            const url = `admin/ajax/offices/paginate?page=${page}`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: this.__('Loading') + '...'
            });

            axios.get(url, {
                params: this.searches
            }).then(res => {
                loading.close();
                this.offices = res.data.data;
            })
            .catch(err => {
                loading.close();
                console.error(err);
            })
        },
        openModalAddEditShow(action, office = null) {
            this.$refs.officeFormAddEdit.showForm(action, office);
        },
        updateList(action = null) {
            this.getOffices(this.offices.current_page ?? 1 );
        },
        askDestroy(office) {
            const self = this;
            Swal.fire({
                title: this.__('Are you sure you want to delete this record?'),
                text: this.__('If you delete this record, you will not be able to recover it'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#187de4',
                cancelButtonColor: '#d33',
                confirmButtonText: this.__("Yes, I'm sure!"),
                cancelButtonText: this.__('Cancel'),
            }).then((result) => {
                if (result.isConfirmed) {
                    self.destroy(office.id);
                }
            });
        },
        destroy(id) {
            const url = `/admin/ajax/offices/${id}/destroy`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: this.__('Deleting') + '...'
            });

            axios.delete(url)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.getOffices();
            }).catch(err => {
                loading.close();
                if(err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: '#ee2d41',
                    });
                }
            });
        },
        clearSearches() {
            this.searches = {
                name: '',
                address: '',
            };
        },
    },
}
</script>

<style>
th {
    text-transform: uppercase;
}
</style>
