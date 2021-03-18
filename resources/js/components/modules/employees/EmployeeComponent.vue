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

            <div v-if="employees.data.length" class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>APELLIDOS</th>
                            <th>EMAIL</th>
                            <th>TELEFONO</th>
                            <th class="text-nowrap d-flex justify-content-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(employee, index) in employees.data" :key="index">
                            <th>{{ index + 1 }}</th>
                            <td>{{ employee.name }}</td>
                            <td>{{ employee.last_name }}</td>
                            <td>{{ employee.email }}</td>
                            <td>{{ employee.phone }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                <button  class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                                    <i class="far fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-clean btn-icon mr-2" @click="openModalAddEdit('edit', employee)" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-clean btn-icon mr-2" @click="askDestroy(employee)" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <pagination :class="'mt-2'" :align="'center'" :limit="5" :data=" employees" @pagination-change-page="getEmployees"></pagination>
            </div>
            <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                No hay ningún elemento para mostrar
            </div>

        </div>

        <employee-form-add-edit ref="employeeFormAddEdit" @updateEmployeeList="updateList()"></employee-form-add-edit>

    </div>
<!--end::Card-->
</template>

<script>
import EmployeeFormAddEdit from './EmployeeFormAddEditComponent';

export default {
    components: {EmployeeFormAddEdit},

    created() {
        this.getEmployees();
    },

    data() {
        return {
            employees: {data:[]}
        }
    },

    methods: {
        getEmployees(page = 1) {
            const url = `admin/ajax/employees/paginate?page=${page}`;
            const loading = this.$vs.loading({
                type: 'points',
                color: '#187de4',
                // background: '#7a76cb',
                text: 'Cargando...'
            });

            axios.get(url)
            .then(res => {
                loading.close();
                this.employees = res.data.data;
            })
            .catch(err => {
                loading.close();
                console.error(err);
            })
        },
        openModalAddEdit(action, employee = null) {
            this.$refs.employeeFormAddEdit.showForm(action, employee);
        },
        updateList(action = null) {
            this.getEmployees(this.employees.current_page ?? 1 );
        },
        askDestroy(employee) {
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
                    self.destroy(employee.id);
                }
            });
        },
        destroy(id) {
            const url = `/admin/ajax/employees/${id}/destroy`;
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
                this.getEmployees();
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

    }
}
</script>

<style>

</style>
