<template>
<!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Empleados
                <span class="d-block text-muted pt-2 font-size-sm">Administración de los empleados</span></h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                <button @click="openModalAddEdit('add')" class="btn btn-primary font-weight-bolder">
                    <i class="fas fa-plus-square"></i> Nuevo
                </button>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">

            <div class="form-row pl-3 align-items-end">

                <div class="col-sm-5 form-group">
                    <label for="nif" ><b>NOMBRE</b></label>
                    <input type="text" class="form-control" name="nif" placeholder="NOMBRE">
                </div>

                <div class="col-10 col-sm-5 form-group">
                    <label for="date" ><b>CIF</b></label>
                    <input type="text" class="form-control" name="nif" placeholder="CIF">
                </div>

                <div class="col-auto form-group">
                    <button title="Eliminar Filtros" type="button"
                        class="btn waves-effect waves-light btn-danger float-right font-weight-bolder">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>

            <div v-if="offices.data.length" class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CIF</th>
                            <th>NOMBRE</th>
                            <th>DIRECCION</th>
                            <th>EMAIL</th>
                            <th>TELEFONO</th>
                            <th>GERENTE</th>
                            <th class="text-nowrap d-flex justify-content-center">Acciones</th>
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
                                <button  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEdit('edit', office)" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-clean btn-icon mr-2" @click="askDestroy(office)" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination :class="'mt-2'" :align="'center'" :limit="5" :data="offices" @pagination-change-page="getOffices"></pagination>
            </div>
            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                No hay ningún elemento para mostrar
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

    data() {
        return {
            offices: {data:[]},
            form: {
                name: '',
                cif: '',
                address: '',
                extra_address: '',
                city: '',
                cp: '',
                province: '',
                country: '',
                phone: '',
                email: '',
                contact_person: ''
            }
        }
    },

    methods: {
        getOffices(page = 1) {
            const url = `admin/ajax/offices/paginate?page=${page}`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: 'Cargando...'
            });

            axios.get(url)
            .then(res => {
                loading.close();
                this.offices = res.data.data;
            })
            .catch(err => {
                loading.close();
                console.error(err);
            })
        },
        openModalAddEdit(action, office = null) {
            this.$refs.officeFormAddEdit.showForm(action, office);
        },
        updateList(action = null) {
            this.getOffices(this.offices.current_page ?? 1 );
        },
        askDestroy(office) {
            const self = this;
            Swal.fire({
                title: '¿Estas seguro que deseas eliminar este registro?',
                text: "Si eliminas este registro, no podras recuperarlo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#187de4',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, estoy seguro!',
                cancelButtonText: "Cancelar",
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
                text: 'Eliminando...'
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
        }

    },
}
</script>

<style>

</style>
