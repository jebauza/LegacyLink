<template>
<div class="modal fade" id="modalAddEditDeceasedProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 v-if="modalType=='add'" class="modal-title" style="text-transform: uppercase;">{{ __('Add') }} WEB</h5>
                <h5 v-else-if="modalType=='edit'" class="modal-title">{{ __('Edit') }} WEB</h5>
                <h5 v-else class="modal-title">WEB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" v-on:submit.prevent="'actionStoreUpdate()'">
            <div class="modal-body">

                <div class="card card-custom">

                    <div class="card-header card-header-tabs-line">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x" role="tablist">
                                <li class="nav-item mr-3">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_web">
                                        <span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
                                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\Devices\Display1.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M11,20 L11,17 C11,16.4477153 11.4477153,16 12,16 C12.5522847,16 13,16.4477153 13,17 L13,20 L15.5,20 C15.7761424,20 16,20.2238576 16,20.5 C16,20.7761424 15.7761424,21 15.5,21 L8.5,21 C8.22385763,21 8,20.7761424 8,20.5 C8,20.2238576 8.22385763,20 8.5,20 L11,20 Z" fill="#000000" opacity="0.3"/>
                                                        <path d="M3,5 L21,5 C21.5522847,5 22,5.44771525 22,6 L22,16 C22,16.5522847 21.5522847,17 21,17 L3,17 C2.44771525,17 2,16.5522847 2,16 L2,6 C2,5.44771525 2.44771525,5 3,5 Z M4.5,8 C4.22385763,8 4,8.22385763 4,8.5 C4,8.77614237 4.22385763,9 4.5,9 L13.5,9 C13.7761424,9 14,8.77614237 14,8.5 C14,8.22385763 13.7761424,8 13.5,8 L4.5,8 Z M4.5,10 C4.22385763,10 4,10.2238576 4,10.5 C4,10.7761424 4.22385763,11 4.5,11 L7.5,11 C7.77614237,11 8,10.7761424 8,10.5 C8,10.2238576 7.77614237,10 7.5,10 L4.5,10 Z" fill="#000000"/>
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="nav-text font-weight-bold">Web</span>
                                    </a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link " data-toggle="tab" href="#kt_tab_client">
                                        <span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
                                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\General\User.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="nav-text font-weight-bold">Declarante</span>
                                    </a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_ceremonies">
                                        <span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
                                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo3\dist/../src/media/svg/icons\Communication\Clipboard-check.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                                        <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                                        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                                    </g>
                                                </svg><!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="nav-text font-weight-bold">Eventos</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="tab-content pt-5">

                            <div class="tab-pane active" id="kt_tab_web" role="tabpanel">
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label :class="['control-label', errors.dprofile_office ? 'text-danger' : '']"><b>Sucursal</b></label>
                                        <vs-select :key="offices.length" filter v-model="form.dprofile_office" :placeholder="__('Select')" state="primary" :disabled="disableOffice">
                                            <vs-option v-for="office in offices" :key="office.id" :label="office.name" :value="office.id">{{ office.name }}</vs-option>
                                        </vs-select>
                                        <small v-if="errors.dprofile_office" class="form-control-feedback text-danger">
                                            {{ errors.dprofile_office[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label :class="['control-label', errors.dprofile_adviser ? 'text-danger' : '']"><b>Agente</b></label>
                                        <vs-select :key="advisers.length" filter v-model="form.dprofile_adviser" :placeholder="__('Select')" state="primary" :disabled="disableAdviser">
                                            <vs-option v-for="adviser in advisers" :key="adviser.id" :label="adviser.fullName" :value="adviser.id">{{ adviser.fullName }}</vs-option>
                                        </vs-select>
                                        <small v-if="errors.dprofile_adviser" class="form-control-feedback text-danger">
                                            {{ errors.dprofile_adviser[0] }}
                                        </small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-sm-6 col-xl-3">
                                        <label :class="['control-label', errors.dprofile_name ? 'text-danger' : '']"><b>{{ __('validation.attributes.name') }}</b></label>
                                        <input  v-model="form.dprofile_name" type="text" :class="['form-control', errors.dprofile_name ? 'is-invalid' : '']" name="name" :placeholder="__('validation.attributes.name')" :disabled="modalType=='show'">
                                        <small v-if="errors.dprofile_name" class="form-control-feedback text-danger">
                                            {{ errors.dprofile_name[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-xl-3">
                                        <label :class="['control-label', errors.dprofile_lastname ? 'text-danger' : '']"><b>{{ __('validation.attributes.last_name') }}</b></label>
                                        <input v-model="form.dprofile_lastname" type="text" :class="['form-control', errors.dprofile_lastname ? 'is-invalid' : '']" name="lastname" :placeholder="__('validation.attributes.last_name')" :disabled="modalType=='show'">
                                        <small v-if="errors.dprofile_lastname" class="form-control-feedback text-danger">
                                            {{ errors.dprofile_lastname[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-xl-3">
                                        <label :class="['control-label', errors.dprofile_birthday ? 'text-danger' : '']"><b>Nacimiento</b></label>
                                        <vs-input
                                            type="date"
                                            v-model="form.dprofile_birthday"
                                            icon-after>
                                            <template #icon>
                                                <i class="ki ki-calendar"></i>
                                            </template>
                                        </vs-input>
                                        <small v-if="errors.dprofile_birthday" class="form-control-feedback text-danger">
                                            {{ errors.dprofile_birthday[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-xl-3">
                                        <label :class="['control-label', errors.dprofile_death ? 'text-danger' : '']"><b>Defunción</b></label>
                                        <vs-input
                                            type="date"
                                            v-model="form.dprofile_death"
                                            icon-after>
                                            <template #icon>
                                                <i class="ki ki-calendar"></i>
                                            </template>
                                        </vs-input>
                                        <small v-if="errors.dprofile_death" class="form-control-feedback text-danger">
                                            {{ errors.dprofile_death[0] }}
                                        </small>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane" id="kt_tab_client" role="tabpanel">
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label :class="['control-label', errors.client_name ? 'text-danger' : '']"><b>{{ __('validation.attributes.name') }}</b></label>
                                        <input v-model="form.client_name" type="text" :class="['form-control', errors.client_name ? 'is-invalid' : '']" name="client_name" :placeholder="__('validation.attributes.name')" required :disabled="modalType=='show'">
                                        <small v-if="errors.client_name" class="form-control-feedback text-danger">
                                            {{ errors.client_name[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label :class="['control-label', errors.client_lastname ? 'text-danger' : '']"><b>{{ __('validation.attributes.last_name') }}</b></label>
                                        <input v-model="form.client_lastname" type="text" :class="['form-control', errors.client_lastname ? 'is-invalid' : '']" name="client_lastname" :placeholder="__('validation.attributes.last_name')" required :disabled="modalType=='show'">
                                        <small v-if="errors.client_lastname" class="form-control-feedback text-danger">
                                            {{ errors.client_lastname[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4">
                                        <label :class="['control-label', errors.client_dni ? 'text-danger' : '']"><b>DNI</b></label>
                                        <input v-model="form.client_dni" type="text" :class="['form-control', errors.client_dni ? 'is-invalid' : '']" name="client_dni" placeholder="dni" required :disabled="modalType=='show'">
                                        <small v-if="errors.client_dni" class="form-control-feedback text-danger">
                                            {{ errors.client_dni[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4">
                                        <label :class="['control-label', errors.client_email ? 'text-danger' : '']"><b>{{ __('validation.attributes.email') }}</b></label>
                                        <input  v-model="form.client_email" type="email" :class="['form-control', errors.client_email ? 'is-invalid' : '']" name="client_email" :placeholder="__('validation.attributes.email')" :disabled="modalType=='show'">
                                        <small v-if="errors.client_email" class="form-control-feedback text-danger">
                                            {{ errors.client_email[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4">
                                        <label :class="['control-label', errors.client_phone ? 'text-danger' : '']"><b>{{ __('validation.attributes.phone') }}</b></label>
                                        <input v-model="form.client_phone" type="text" :class="['form-control', errors.client_phone ? 'is-invalid' : '']" name="client_phone" :placeholder="__('validation.attributes.phone')" :disabled="modalType=='show'">
                                        <small v-if="errors.client_phone" class="form-control-feedback text-danger">
                                            {{ errors.client_phone[0] }}
                                        </small>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane" id="kt_tab_ceremonies" role="tabpanel">
                                <div class="form-row">
                                    <div class="form-group col-sm-6 col-lg-4">
                                        <el-date-picker
                                                v-model="formCeremony.start"
                                                type="datetime"
                                                placeholder="Inicio">
                                        </el-date-picker>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4">
                                        <el-date-picker
                                                v-model="formCeremony.end"
                                                type="datetime"
                                                placeholder="Fin">
                                        </el-date-picker>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4">
                                        <el-select v-if="ceremony_types.length" v-model="formCeremony.type_id" filterable placeholder="Select">
                                            <el-option v-for="item in ceremony_types" :key="item.id" :label="item.name" :value="item.id"></el-option>
                                        </el-select>
                                    </div>
                                    <div class="form-group col-12">
                                        <el-input
                                            type="textarea"
                                            :rows="1"
                                            placeholder="Informacion Adicional"
                                            v-model="formCeremony.additional_info">
                                        </el-input>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-6 col-xl-4">
                                        <el-input placeholder="Dirreccion" v-model="formCeremony.address" clearable></el-input>
                                    </div>
                                    <div class="form-group col-sm-6 col-xl-4">
                                        <el-input placeholder="Sala" v-model="formCeremony.room_name" clearable></el-input>
                                    </div>
                                    <div class="form-group col-6 col-sm-5 col-lg-3 col-xl-2">
                                         <el-checkbox v-model="formCeremony.main" label="Principal" border></el-checkbox>
                                    </div>
                                    <div class="form-group col-auto">
                                        <el-button v-if="!formCeremony.aux_id" @click="addCeremony()" type="primary" round>Adicionar</el-button>
                                        <el-button v-else @click="updateCeremony()" type="success" round>Actualizar</el-button>
                                    </div>

                                </div>

                                <div v-if="errors.ceremonies" class="row mb-2">
                                    <vs-alert color="danger" >
                                        <template #title>
                                            Error
                                        </template>
                                            {{ errors.ceremonies }}
                                    </vs-alert>
                                </div>

                                <div class="row">
                                    <vs-table class="table">
                                        <template #thead>
                                            <vs-tr>
                                                <vs-th>
                                                    #
                                                </vs-th>
                                                <vs-th>
                                                    Ceremonia
                                                </vs-th>
                                                <vs-th>
                                                    Duracion
                                                </vs-th>
                                                <vs-th>
                                                    Dirreccion
                                                </vs-th>
                                                <vs-th>

                                                </vs-th>
                                            </vs-tr>
                                        </template>

                                        <template #tbody>
                                            <vs-tr :key="index" v-for="(ceremony, index) in form.ceremonies" >
                                                <vs-td>
                                                    <div class="d-flex align-items-center mr-1">{{ index+1 }}
														<i v-if="ceremony.main" class="flaticon2-correct text-success icon-md ml-2"></i>
                                                    </div>
                                                </vs-td>
                                                <vs-td>
                                                    {{ ceremony.type_name }}
                                                </vs-td>
                                                <vs-td>{{ ceremony.start }} / {{ ceremony.end }}</vs-td>
                                                <vs-td>{{ ceremony.address }}</vs-td>
                                                <vs-td>
                                                    <div class="d-flex justify-content-center">
                                                        <vs-button icon color="primary" border @click="loadFormCeremony(ceremony)">
                                                            <i class='fas fa-pencil-alt'></i>
                                                        </vs-button>
                                                        <vs-button icon color="danger" border @click="removeCeremony(ceremony)">
                                                            <i class='fas fa-trash-alt'></i>
                                                        </vs-button>
                                                    </div>
                                                </vs-td>

                                                <template #expand>
                                                    <div class="row con-content">
                                                        <div class="col-10 col-lg-11">
                                                            <p>
                                                                {{ ceremony.additional_info }}
                                                            </p>
                                                        </div>
                                                        <div class="col-auto">

                                                        </div>
                                                    </div>
                                                </template>
                                            </vs-tr>
                                        </template>
                                    </vs-table>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <div v-if="modalType!='show'" class="modal-footer">
                <button type="button" @click="actionStoreUpdate()" class="btn btn-primary">{{ __('Save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    watch: {
        'form.dprofile_office': function (newValue, oldValue) {
            this.form.dprofile_adviser = '';
            this.getAdvisers();
        }
    },

    created() {
        this.getOffices();
        this.getAdvisers();
        this.getCeremonyTypes();
    },

    data() {
        return {
            modalType: 'add', //add, edit
            offices: [],
            advisers: [],
            ceremony_types: [],

            form: {
                dprofile_office: '',
                dprofile_adviser: '',
                dprofile_name: '',
                dprofile_lastname: '',
                dprofile_birthday: '',
                dprofile_death: '',

                client_name: '',
                client_lastname: '',
                client_dni: '',
                client_email: '',
                client_phone: '',
                ceremonies: []
            },
            errors: {},

            formCeremony: {
                type_id: '',
                type_name: '',
                main: false,
                start: '',
                end: '',
                additional_info: '',
                address: '',
                room_name: '',
                aux_id: '',
                id: ''
            },

        }
    },

    methods: {
        getOffices() {
            const url = `/admin/ajax/offices`;

            axios.get(url)
            .then(res => {
                this.offices = res.data.data;
                if (this.offices.length == 1) {
                    this.form.dprofile_office = this.offices[0].id
                }
            })
            .catch(err => {
                console.error(err);
            })
        },
        getAdvisers() {
            const url = `/admin/ajax/employees?role=3&office=${this.form.dprofile_office}`;

            axios.get(url, )
            .then(res => {
                this.advisers = res.data.data;
                if (this.advisers.length == 1) {
                    this.form.dprofile_adviser = this.advisers[0].id
                }
            })
            .catch(err => {
                console.error(err);
            })
        },
        getCeremonyTypes() {
            const url = `/admin/ajax/ceremony_types`;

            axios.get(url, )
            .then(res => {
                this.ceremony_types = res.data;
            })
            .catch(err => {
                console.error(err);
            })
        },
        showForm(action, employee = null) {

            if(this.modalType != action) {
                this.clearForm();
            }

            this.modalType = action;
            /* if( employee && (action.includes('edit') || action.includes('show'))) {
                this.form = {
                    name: employee.name,
                    last_name: employee.last_name,
                    email: employee.email,
                    phone: employee.phone,
                    password: '',
                    extra_info: employee.extra_info,
                    offices: employee.offices.map(o => o.id),
                    role: employee.role ? employee.role.id : '',
                    id: employee.id
                };
            } */
            this.errors = {};
            $('#modalAddEditDeceasedProfile').modal('show');
        },
        clearForm() {
            this.form = {
                dprofile_office: '',
                dprofile_adviser: '',
                dprofile_name: '',
                dprofile_lastname: '',
                dprofile_birthday: '',
                dprofile_death: '',
                client_name: '',
                client_lastname: '',
                client_dni: '',
                client_email: '',
                client_phone: ''
            };
            this.errors = {};
        },
        clearFormCeremony() {
            this.formCeremony = {
                type_id: '',
                type_name: '',
                main: false,
                start: '',
                end: '',
                additional_info: '',
                address: '',
                room_name: '',
                aux_id: ''
            };
            this.errors = {};
        },
        actionStoreUpdate() {
            if(this.modalType == 'add') {
                this.store();
            } else if(this.modalType == 'edit') {
                this.update();
            }
        },
        addCeremony() {
            if (this.formCeremony.main) {
                this.form.ceremonies = this.form.ceremonies.map(c => {
                    c.main = false;
                    return c
                });
            }

            this.form.ceremonies.push({
                type_id: this.formCeremony.type_id,
                type_name: this.ceremony_types.find(c => this.formCeremony.type_id == c.id).name,
                main: this.formCeremony.main,
                start: moment(this.formCeremony.start).format('YYYY-MM-DD HH:mm:ss'),
                end: moment(this.formCeremony.end).format('YYYY-MM-DD HH:mm:ss'),
                additional_info: this.formCeremony.additional_info,
                address: this.formCeremony.address,
                room_name: this.formCeremony.room_name,
                aux_id: Math.random().toString(36).substr(2, 5)
            });

            this.clearFormCeremony();
        },
        updateCeremony() {
            this.form.ceremonies = this.form.ceremonies.map(c => {
                    if (this.formCeremony.main) {
                        c.main = false;
                    }

                    if (c.aux_id === this.formCeremony.aux_id) {
                        return {
                            type_id: this.formCeremony.type_id,
                            type_name: this.ceremony_types.find(c => this.formCeremony.type_id == c.id).name,
                            main: this.formCeremony.main,
                            start: moment(this.formCeremony.start).format('YYYY-MM-DD HH:mm:ss'),
                            end: moment(this.formCeremony.end).format('YYYY-MM-DD HH:mm:ss'),
                            additional_info: this.formCeremony.additional_info,
                            address: this.formCeremony.address,
                            room_name: this.formCeremony.room_name,
                            aux_id: this.formCeremony.aux_id,
                        }
                    }

                    return c;
            });

            this.clearFormCeremony();
        },
        removeCeremony(ceremony) {
            // this.form.ceremonies.splice(index, 1);
            const index = this.form.ceremonies.findIndex(c => c.aux_id === ceremony.aux_id);
            this.$delete(this.form.ceremonies, index);
        },
        loadFormCeremony(ceremony) {
            this.clearFormCeremony();
            this.formCeremony = {
                type_id: ceremony.type_id,
                type_name: ceremony.type_name,
                main: ceremony.main,
                start: ceremony.start,
                end: ceremony.end,
                additional_info: ceremony.additional_info,
                address:  ceremony.address,
                room_name: ceremony.room_name,
                aux_id: ceremony.aux_id ? ceremony.aux_id : ''
            }
        },

        store() {
            const url = '/admin/ajax/webs/store';
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: this.__('Loading') + '...'
            });

            axios.post(url, this.form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modalAddEditDeceasedProfile').modal('hide');
                this.clearForm();
                this.$emit('updateDeceasedProfileList', 'add');
            })
            .catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                    this.errorsCeremonies();
                    Swal.fire({
                        title: 'Error',
                        icon: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }else if(err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
            })
        },
        errorsCeremonies() {
            //Buscar los errores de los elementos del array ceremonies
            if(Object.keys(this.errors).length !== 0){
                if(!this.errors.ceremonies){
                    for (let i = 0; i < this.form.ceremonies.length; i++) {
                        for (let value of Object.keys(this.formCeremony)) {
                            if(this.errors.hasOwnProperty(`ceremonies.${i}.${value}`)){
                                this.errors.ceremonies = `Revisar ceremonia #${i+1} ` + this.errors[`ceremonies.${i}.${value}`];
                                break;
                            }
                        }

                        if (this.errorCeremonies) {
                            break;
                        }
                    }
                }
            }
        }
        /* update() {
            const url = `/admin/ajax/employees/${this.form.id}/update`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                text: 'Cargando...'
            });

            axios.put(url, this.form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modalAddEditEmployee').modal('hide');
                this.clearForm();
                this.$emit('updateEmployeeList', 'edit');
            }).catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                }else if(err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: '#ee2d41',
                    });
                }
            });
        }, */
    },

    computed: {
        disableOffice() {
            return this.offices.length < 2;
        },
        disableAdviser() {
            return this.advisers.length < 2;
        },
        disableCeremonyTypes() {
            return this.ceremony_types.length < 2;
        },
    },
}
</script>

<style>
.vs-input {
    width: 100%;
}

.el-input {
    width: 100% !important;
}

i {
    color: unset !important
}
</style>
