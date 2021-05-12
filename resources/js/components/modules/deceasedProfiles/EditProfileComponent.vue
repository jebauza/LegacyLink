<template>
<div class="modal fade" id="modalEditDeceasedProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 v-if="modalType=='edit'" class="modal-title" style="text-transform: uppercase;">{{ __('Edit') }} WEB</h5>
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
                                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_web_edit">
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
                                    <a class="nav-link " data-toggle="tab" href="#kt_tab_client_edit">
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
                                    <a class="nav-link" data-toggle="tab" href="#kt_tab_ceremonies_edit">
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

                            <div class="tab-pane active" id="kt_tab_web_edit" role="tabpanel">
                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label :class="['control-label', errorsProfile.office ? 'text-danger' : '']"><b>Sucursal</b></label>
                                        <vs-select :key="offices.length" filter v-model="formProfile.office" :placeholder="__('Select')" state="primary" :disabled="disableOffice">
                                            <vs-option v-for="office in offices" :key="office.id" :label="`${office.name}, ${office.cp} ${office.city}`" :value="office.id">{{ `${office.name}, ${office.cp} ${office.city}` }}</vs-option>
                                        </vs-select>
                                        <small v-if="errorsProfile.office" class="form-control-feedback text-danger">
                                            {{ errorsProfile.office[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label :class="['control-label', errorsProfile.adviser ? 'text-danger' : '']"><b>Agente</b></label>
                                        <vs-select :key="advisers.length" filter v-model="formProfile.adviser" :placeholder="__('Select')" state="primary" :disabled="disableAdviser">
                                            <vs-option :key="0" :label="''" :value="''">{{ '' }}</vs-option>
                                            <vs-option v-for="(adviser, index) in advisers" :key="index+1" :label="`${adviser.fullName}, ${adviser.email}`" :value="adviser.id">{{ `${adviser.fullName}, ${adviser.email}` }}</vs-option>
                                        </vs-select>
                                        <small v-if="errorsProfile.adviser" class="form-control-feedback text-danger">
                                            {{ errorsProfile.adviser[0] }}
                                        </small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-sm-6 col-xl-3">
                                        <label :class="['control-label', errorsProfile.name ? 'text-danger' : '']"><b>{{ __('validation.attributes.name') }}</b></label>
                                        <input  v-model="formProfile.name" type="text" :class="['form-control', errorsProfile.name ? 'is-invalid' : '']" name="name" :placeholder="__('validation.attributes.name')" :disabled="modalType=='show'">
                                        <small v-if="errorsProfile.name" class="form-control-feedback text-danger">
                                            {{ errorsProfile.name[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-xl-3">
                                        <label :class="['control-label', errorsProfile.last_name ? 'text-danger' : '']"><b>{{ __('validation.attributes.last_name') }}</b></label>
                                        <input v-model="formProfile.last_name" type="text" :class="['form-control', errorsProfile.last_name ? 'is-invalid' : '']" name="lastname" :placeholder="__('validation.attributes.last_name')" :disabled="modalType=='show'">
                                        <small v-if="errorsProfile.last_name" class="form-control-feedback text-danger">
                                            {{ errorsProfile.last_name[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-xl-3">
                                        <label :class="['control-label', errorsProfile.birthday ? 'text-danger' : '']"><b>Nacimiento</b></label>
                                        <vs-input
                                            type="date"
                                            v-model="formProfile.birthday"
                                            icon-after>
                                            <template #icon>
                                                <i class="ki ki-calendar"></i>
                                            </template>
                                        </vs-input>
                                        <small v-if="errorsProfile.birthday" class="form-control-feedback text-danger">
                                            {{ errorsProfile.birthday[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-xl-3">
                                        <label :class="['control-label', errorsProfile.death ? 'text-danger' : '']"><b>Defunción</b></label>
                                        <vs-input
                                            type="date"
                                            v-model="formProfile.death"
                                            icon-after>
                                            <template #icon>
                                                <i class="ki ki-calendar"></i>
                                            </template>
                                        </vs-input>
                                        <small v-if="errorsProfile.death" class="form-control-feedback text-danger">
                                            {{ errorsProfile.death[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-12">
                                        <button type="button" @click="updateProfile()"  class="btn btn-primary float-right">Actualizar</button>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane" id="kt_tab_client_edit" role="tabpanel">

                                <div class="form-row">
                                    <div class="form-group col-sm-6">
                                        <label :class="['control-label', errorsClient.name ? 'text-danger' : '']"><b>{{ __('validation.attributes.name') }}</b></label>
                                        <input v-model="formClient.name" type="text" :class="['form-control', errorsClient.name ? 'is-invalid' : '']" name="client_name" :placeholder="__('validation.attributes.name')" required :disabled="modalType=='show'">
                                        <small v-if="errorsClient.name" class="form-control-feedback text-danger">
                                            {{ errorsClient.name[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label :class="['control-label', errorsClient.lastname ? 'text-danger' : '']"><b>{{ __('validation.attributes.last_name') }}</b></label>
                                        <input v-model="formClient.lastname" type="text" :class="['form-control', errorsClient.lastname ? 'is-invalid' : '']" name="client_lastname" :placeholder="__('validation.attributes.last_name')" required :disabled="modalType=='show'">
                                        <small v-if="errorsClient.lastname" class="form-control-feedback text-danger">
                                            {{ errorsClient.lastname[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4">
                                        <label :class="['control-label', errorsClient.dni ? 'text-danger' : '']"><b>DNI</b></label>
                                        <input v-model="formClient.dni" type="text" :class="['form-control', errorsClient.dni ? 'is-invalid' : '']" name="client_dni" placeholder="dni" required :disabled="modalType=='show'">
                                        <small v-if="errorsClient.dni" class="form-control-feedback text-danger">
                                            {{ errorsClient.dni[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4">
                                        <label :class="['control-label', errorsClient.email ? 'text-danger' : '']"><b>{{ __('validation.attributes.email') }}</b></label>
                                        <input  v-model="formClient.email" type="email" :class="['form-control', errorsClient.email ? 'is-invalid' : '']" name="client_email" :placeholder="__('validation.attributes.email')" :disabled="modalType=='show'">
                                        <small v-if="errorsClient.email" class="form-control-feedback text-danger">
                                            {{ errorsClient.email[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-sm-6 col-lg-4">
                                        <label :class="['control-label', errorsClient.phone ? 'text-danger' : '']"><b>{{ __('validation.attributes.phone') }}</b></label>
                                        <input v-model="formClient.phone" type="text" :class="['form-control', errorsClient.phone ? 'is-invalid' : '']" name="client_phone" :placeholder="__('validation.attributes.phone')" :disabled="modalType=='show'">
                                        <small v-if="errorsClient.phone" class="form-control-feedback text-danger">
                                            {{ errorsClient.phone[0] }}
                                        </small>
                                    </div>

                                    <div class="form-group col-12">
                                        <button type="button" @click="updateClient()"  class="btn btn-primary float-right">Actualizar</button>
                                    </div>
                                </div>


                            </div>

                            <div class="tab-pane" id="kt_tab_ceremonies_edit" role="tabpanel">
                                <div class="form-row">
                                    <div class="form-group col-sm-6 col-lg-4">
                                        <el-date-picker
                                                v-model="formCeremony.start"
                                                type="datetime"
                                                placeholder="Inicio"
                                                :picker-options="pickerOptions"
                                                default-time="12:00:00"
                                                format="dd/MM/yyyy HH:mm">
                                        </el-date-picker>
                                        <small v-if="errorsCeremony.start" class="form-control-feedback text-danger">
                                            {{ errorsCeremony.start[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4">
                                        <el-date-picker
                                                v-model="formCeremony.end"
                                                type="datetime"
                                                placeholder="Fin"
                                                :picker-options="pickerOptions"
                                                default-time="12:00:00"
                                                format="dd/MM/yyyy HH:mm">
                                        </el-date-picker>
                                        <small v-if="errorsCeremony.end" class="form-control-feedback text-danger">
                                            {{ errorsCeremony.end[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4">
                                        <el-select v-if="ceremony_types.length" v-model="formCeremony.type_id" filterable placeholder="Select">
                                            <el-option v-for="item in ceremony_types" :key="item.id" :label="item.name" :value="item.id"></el-option>
                                        </el-select>
                                        <small v-if="errorsCeremony.type_id" class="form-control-feedback text-danger">
                                            {{ errorsCeremony.type_id[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-12">
                                        <el-input
                                            type="textarea"
                                            :rows="1"
                                            placeholder="Informacion Adicional"
                                            v-model="formCeremony.additional_info">
                                        </el-input>
                                        <small v-if="errorsCeremony.additional_info" class="form-control-feedback text-danger">
                                            {{ errorsCeremony.additional_info[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-6 col-xl-4">
                                        <el-input placeholder="Dirrección" v-model="formCeremony.address" clearable></el-input>
                                        <small v-if="errorsCeremony.address" class="form-control-feedback text-danger">
                                            {{ errorsCeremony.address[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-4 col-xl-4">
                                        <el-input placeholder="Sala" v-model="formCeremony.room_name" clearable></el-input>
                                        <small v-if="errorsCeremony.room_name" class="form-control-feedback text-danger">
                                            {{ errorsCeremony.room_name[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-sm-6 col-lg-2 col-xl-auto">
                                         <vs-tooltip bottom>
                                            <vs-switch v-model="formCeremony.streaming">
                                                <i class='fas fa-video' ></i>
                                            </vs-switch>
                                            <template #tooltip>
                                                Transmisión en vivo
                                            </template>
                                        </vs-tooltip>
                                    </div>
                                    <div class="form-group col-sm-5 col-lg-auto">
                                         <el-checkbox v-model="formCeremony.main" label="Principal" border></el-checkbox>
                                         <small v-if="errorsCeremony.main" class="form-control-feedback text-danger">
                                            {{ errorsCeremony.main[0] }}
                                        </small>
                                    </div>
                                    <div class="form-group col-auto">
                                        <el-button v-if="!formCeremony.id" type="primary" @click="storeCeremony()" round>Añadir</el-button>
                                        <el-button v-else type="success" @click="updateCeremony()" round>Actualizar</el-button>
                                    </div>

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
                                                    Dirrección
                                                </vs-th>
                                                <vs-th>
                                                    En vivo
                                                </vs-th>
                                                <vs-th>

                                                </vs-th>
                                            </vs-tr>
                                        </template>

                                        <template #tbody>
                                            <vs-tr :key="index" v-for="(ceremony, index) in ceremonies" >
                                                <vs-td>
                                                    <div class="d-flex align-items-center mr-1">{{ index+1 }}
														<i v-if="ceremony.main" class="flaticon2-correct text-success icon-md ml-2"></i>
                                                    </div>
                                                </vs-td>
                                                <vs-td>
                                                    {{ ceremony.type.name }}
                                                </vs-td>
                                                <vs-td>{{ ceremony.start }} / {{ ceremony.end }}</vs-td>
                                                <vs-td>{{ ceremony.address }}</vs-td>
                                                <vs-td>
                                                    <div class="d-flex justify-content-center">
														<i v-if="ceremony.streaming" class="fas fa-video text-success icon-md"></i>
                                                    </div>
                                                </vs-td>
                                                <vs-td>
                                                    <div class="d-flex justify-content-center">
                                                        <vs-button icon color="primary" border @click="loadFormCeremony(ceremony)">
                                                            <i class='fas fa-pencil-alt'></i>
                                                        </vs-button>
                                                        <vs-button icon color="danger" border @click="destroyCeremony(ceremony)">
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

            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {
    watch: {
        'formProfile.office': function (newValue, oldValue) {
            if (oldValue != '') {
                this.formProfile.adviser = ''
            }
            this.getAdvisers();
        },
        'formCeremony.start': function (newValue, oldValue) {
            if (newValue instanceof Date) {
                const date = new Date();
                this.formCeremony.end = date.setTime(newValue.getTime() + 3600 * 1000 * 2);
            }
        }
    },

    created() {
        this.getOffices();
        this.getAdvisers();
        this.getCeremonyTypes();
    },

    data() {
        return {
            modalType: 'edit', //add, edit
            offices: [],
            advisers: [],
            ceremony_types: [],
            ceremonies: [],

            formProfile: {
                office: '',
                adviser: '',
                name: '',
                last_name: '',
                birthday: '',
                death: '',
                id: ''
            },
            errorsProfile: {},

            formClient: {
                name: '',
                lastname: '',
                dni: '',
                email: '',
                phone: '',
                id: ''
            },
            errorsClient: {},

            formCeremony: {
                type_id: '',
                type_name: '',
                main: false,
                start: '',
                end: '',
                additional_info: '',
                address: '',
                room_name: '',
                streaming: false,
                id: '',
                profile_id: ''
            },
            errorsCeremony: {},

            pickerOptions: {
                shortcuts: [{
                    text: 'Hoy',
                    onClick(picker) {
                        picker.$emit('pick', new Date());
                    }
                }, {
                    text: 'Mañama',
                    onClick(picker) {
                        const date = new Date();
                        date.setTime(date.getTime() + 3600 * 1000 * 24);
                        picker.$emit('pick', date);
                    }
                }, {
                    text: 'Pasado',
                    onClick(picker) {
                        const date = new Date();
                        date.setTime(date.getTime() + 3600 * 1000 * 48);
                        picker.$emit('pick', date);
                    }
                }]
            },

        }
    },

    methods: {
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
        getAdvisers() {
            const url = `/admin/ajax/employees?role=2-3&office=${this.formProfile.office}`;

            axios.get(url, )
            .then(res => {
                this.advisers = res.data.data;
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
        getCeremonies(profile_id) {
            const url = `/admin/ajax/ceremonies?profile=${profile_id}`;

            axios.get(url, )
            .then(res => {
                this.ceremonies = res.data;
            })
            .catch(err => {
                console.error(err);
            })
        },
        showForm(action, profile) {
            console.log(profile);
            this.clearForm();
            this.modalType = action;

            this.formProfile= {
                office: profile.office.id,
                adviser: profile.adviser.id,
                name: profile.name,
                last_name: profile.last_name,
                birthday: moment(profile.birthday).format('YYYY-MM-DD'),
                death: moment(profile.death).format('YYYY-MM-DD'),
                id:  profile.id
            },

            this.formClient= {
                name: profile.declarant.name,
                lastname: profile.declarant.lastname,
                dni: profile.declarant.dni,
                email: profile.declarant.email,
                phone: profile.declarant.phone,
                id: profile.declarant.id,
            },

            this.getCeremonies(profile.id);
            this.formCeremony.profile_id = profile.id;

            $('#modalEditDeceasedProfile').modal('show');
        },
        clearForm() {
            this.formProfile= {
                office: '',
                adviser: '',
                name: '',
                last_name: '',
                birthday: '',
                death: '',
                id: ''
            };
            this.errorsProfile= {};

            this.formClient= {
                name: '',
                lastname: '',
                dni: '',
                email: '',
                phone: '',
                id: ''
            };
            this.errorsClient= {};

            this.clearFormCeremony()

            this.ceremonies = [];
        },
        clearFormCeremony() {
            this.formCeremony= {
                type_id: '',
                type_name: '',
                main: false,
                start: '',
                end: '',
                additional_info: '',
                address: '',
                room_name: '',
                streaming: false,
                id: '',
                profile_id: this.formProfile.id
            };
            this.errorsCeremony= {};
        },
        updateProfile() {
            const url = `/admin/ajax/webs/${this.formProfile.id}/update`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: this.__('Loading') + '...'
            });

            axios.put(url, this.formProfile)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.errorsProfile= {};
                this.$emit('updateDeceasedProfileList', 'edit');
            }).catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errorsProfile = err.response.data.errors;
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
        },
        updateClient() {
            const url = `/admin/ajax/clients/${this.formClient.id}/update`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: this.__('Loading') + '...'
            });

            axios.put(url, this.formClient)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.errorsClient= {};
                this.$emit('updateDeceasedProfileList', 'edit');
            }).catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errorsClient = err.response.data.errors;
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
        },
        storeCeremony() {
            const url = '/admin/ajax/ceremonies/store';
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: 'Cargando...'
            });

            let form = this.formCeremony;
            form.start = moment(this.formCeremony.start).format('YYYY-MM-DD HH:mm:ss');
            form.end = moment(this.formCeremony.end).format('YYYY-MM-DD HH:mm:ss');

            axios.post(url, form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.clearFormCeremony();
                this.$emit('updateDeceasedProfileList', 'edit');
                this.getCeremonies(this.formProfile.id);
            })
            .catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errorsCeremony = err.response.data.errors;
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
        loadFormCeremony(ceremony) {
            this.clearFormCeremony();
            this.formCeremony = {
                type_id: ceremony.type_id,
                main: ceremony.main,
                start: ceremony.start,
                end: ceremony.end,
                additional_info: ceremony.additional_info,
                address:  ceremony.address,
                room_name: ceremony.room_name,
                streaming: ceremony.streaming ? true : false,
                id: ceremony.id
            }
        },
        updateCeremony() {
            const url = `/admin/ajax/ceremonies/${this.formCeremony.id}/update`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: 'Cargando...'
            });

            let form = this.formCeremony;
            form.start = moment(this.formCeremony.start).format('YYYY-MM-DD HH:mm:ss');
            form.end = moment(this.formCeremony.end).format('YYYY-MM-DD HH:mm:ss');

            axios.put(url, form)
            .then(res => {
                loading.close();
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.clearFormCeremony();
                this.$emit('updateDeceasedProfileList', 'edit');
                this.getCeremonies(this.formProfile.id);
            })
            .catch(err => {
                loading.close();
                if(err.response && err.response.status == 422) {
                    this.errorsCeremony = err.response.data.errors;
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
        destroyCeremony(ceremony) {
            const url = `/admin/ajax/ceremonies/${ceremony.id}/destroy`;
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
                this.$emit('updateDeceasedProfileList', 'edit');
                this.getCeremonies(this.formProfile.id);
            })
            .catch(err => {
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
            })
        },

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
