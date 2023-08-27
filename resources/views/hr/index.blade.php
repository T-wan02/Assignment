@extends('layouts.master')

@section('content')
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="ms-auto btn btn-danger" id="logout">Logout</button>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>Employee List</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployee">+
                            Add</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Job Title</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeList">
                                    <tr>
                                        <td colspan="6">
                                            <p class="placeholder-glow">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <p class="placeholder-glow">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <p class="placeholder-glow">
                                                <span class="placeholder col-12"></span>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmployeeForm">
                        <div class="form-group mb-2">
                            <label for="name">Name :</label>
                            <input type="text" id="name" placeholder="Enter name" class="form-control"
                                name="name">
                        </div>
                        <div class="form-group mb-2">
                            <label for="email">Email :</label>
                            <input type="email" id="email" placeholder="Enter email" class="form-control"
                                name="email">
                        </div>
                        <div class="form-group mb-2">
                            <label for="phone">Phone :</label>
                            <input type="text" id="phone" placeholder="Enter phone number" class="form-control"
                                name="phone_number">
                        </div>
                        <div class="form-group mb-2">
                            <label for="job_title">Job Title :</label>
                            <input type="text" id="job_title" placeholder="Enter job title" class="form-control"
                                name="job_title">
                        </div>
                        <button type="submit" class="btn btn-primary d-block mx-auto"
                            data-bs-dismiss="modal">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editEmployeeForm"></form>
                </div>
            </div>
        </div>
    </div>

    {{-- Toast container --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastContainer">
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Loader btn --}}
    <script src="{{ asset('/asset/js/loaderBtn.js') }}"></script>
    {{-- Toast js --}}
    <script src="{{ asset('/asset/js/toast.js') }}"></script>

    <script>
        const toastContainer = document.getElementById('toastContainer');

        const headers = {
            'Authorization': `Bearer ${accessToken}`,
            'Content-Type': 'multipart/form-data'
        };

        function handleDelete(index) {
            const deleteButton = document.getElementById(`delBtn-${index}`);
            const row = deleteButton.closest('tr');

            const employeeId = deleteButton.dataset.id;

            const confirmDelete = confirm('Are you sure you want to delete this employee?');

            if (confirmDelete) {
                axios.delete(`/api/employees/${employeeId}`, {
                    headers
                }).then(({
                    data
                }) => {
                    if (data.status === 'success') {
                        showToast(toastContainer, data.message, 'red');
                        row.remove();
                    } else {
                        console.log(data.message);
                    }
                }).catch(error => {
                    console.error('Error deleting employee:', error);
                });
            }
        }

        function handleEdit(index) {
            const editButton = document.getElementById(`editBtn-${index}`);
            const employeeId = editButton.dataset.id;

            const editModal = document.getElementById('editModal');
            const editEmployeeForm = editModal.querySelector('#editEmployeeForm');

            axios.get(`/api/employees/edit/${employeeId}`, {
                headers
            }).then(({
                data
            }) => {
                if (data.status === 'success') {
                    const employee = data.data;

                    editEmployeeForm.setAttribute('data-id', employeeId);
                    editEmployeeForm.innerHTML = `
                         <div class="form-group mb-2">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" name="name" value="${employee.name}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" value="${employee.email}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="editPhoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="editPhoneNumber" name="phone_number" value="${employee.phone_number}">
                        </div>
                        <div class="form-group mb-2">
                            <label for="editJobTitle">Job Title</label>
                            <input type="text" class="form-control" id="editJobTitle" name="job_title" value="${employee.job_title}">
                        </div>
                        <button type="submit" class="btn btn-primary d-block mx-auto" data-bs-dismiss="modal">Save
                            Changes</button>
                    `

                    //  edit employee form submit
                    editEmployeeForm.addEventListener('submit', (e) => {
                        e.preventDefault();

                        const employeeId = editEmployeeForm.dataset.id;

                        // Get the formData
                        const updatedEmployee = new FormData(e.target);

                        // Send API request to update employee data
                        axios.post(`/api/employees/${employeeId}?_method=PUT`,
                                updatedEmployee, {
                                    headers
                                })
                            .then(
                                ({
                                    data
                                }) => {
                                    if (data.status === 'success') {
                                        const employees = data.data;

                                        showToast(toastContainer, 'Updated successfully');

                                        indexNumber = 1;

                                        employeeList.innerHTML = ``;
                                        if (employees.length > 0) {
                                            employees.forEach((employee, index) => {
                                                employeeList.innerHTML += `
                                                    <tr>
                                                            <td id="employeeName-${indexNumber}">${employee.name}</td>
                                                            <td id="employeeEmail-${indexNumber}">${employee.email}</td>
                                                            <td id="employeePhone-${indexNumber}">${employee.phone_number}</td>
                                                            <td id="employeeJobTitle-${indexNumber}">${employee.job_title}</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-dark mb-1" id="editBtn-${indexNumber}" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${employee.id}" onClick="handleEdit(${indexNumber})">Edit</button>
                                                                <button class="btn btn-sm btn-danger mb-1" id="delBtn-${indexNumber}" data-id="${employee.id}" onClick="handleDelete(${indexNumber})">Delete</button>
                                                            </td>
                                                    </tr>
                                                `;
                                                indexNumber++;
                                            });
                                        }
                                    } else {
                                        showToast(toastContainer, data.message, 'error');
                                    }
                                }).catch(error => {
                                showToast(toastContainer, data.message, 'error');
                            });
                    });
                }
            }).catch(error => {
                console.error('Error fetching employee data for edit:', error);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const employeeList = document.getElementById('employeeList');

            let indexNumber = 1;

            axios.get('{{ route('employees.index') }}', {
                headers
            }).then(({
                data
            }) => {
                if (data.status === 'success') {
                    const employees = data.data;

                    employeeList.innerHTML = ``;
                    if (employees.length > 0) {
                        employees.forEach((employee, index) => {
                            employeeList.innerHTML += `
                              <tr>
                                   <td id="employeeName-${indexNumber}">${employee.name}</td>
                                   <td id="employeeEmail-${indexNumber}">${employee.email}</td>
                                   <td id="employeePhone-${indexNumber}">${employee.phone_number}</td>
                                   <td id="employeeJobTitle-${indexNumber}">${employee.job_title}</td>
                                   <td>
                                        <button class="btn btn-sm btn-dark mb-1" id="editBtn-${indexNumber}" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${employee.id}" onClick="handleEdit(${indexNumber})">Edit</button>
                                        <button class="btn btn-sm btn-danger mb-1" id="delBtn-${indexNumber}" data-id="${employee.id}" onClick="handleDelete(${indexNumber})">Delete</button>
                                   </td>
                              </tr>
                         `;
                            indexNumber++;
                        });
                    }
                }
            });

            // Add employee form submit
            const addEmployeeForm = document.getElementById('addEmployeeForm');
            addEmployeeForm.addEventListener('submit', (e) => {
                e.preventDefault();

                // Get the formData
                const formData = new FormData(addEmployeeForm);
                console.log(formData.get('email'));

                axios.post('{{ route('employees.store') }}', formData, {
                    headers
                }).then(({
                    data
                }) => {
                    if (data.status === 'success') {
                        showToast(toastContainer, data.message);
                        const employee = data.data;
                        employeeList.innerHTML += `
                              <tr>
                                   <td id="employeeName-${indexNumber}">${employee.name}</td>
                                   <td id="employeeEmail-${indexNumber}">${employee.email}</td>
                                   <td id="employeePhone-${indexNumber}">${employee.phone_number}</td>
                                   <td id="employeeJobTitle-${indexNumber}">${employee.job_title}</td>
                                   <td>
                                        <button class="btn btn-sm btn-dark mb-1" id="editBtn-${indexNumber}" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${employee.id}" onClick="handleEdit(${indexNumber})">Edit</button>
                                        <button class="btn btn-sm btn-danger mb-1" id="delBtn-${indexNumber}" data-id="${employee.id}" onClick="handleDelete(${indexNumber})">Delete</button>
                                   </td>
                              </tr>
                         `;
                        indexNumber++;
                    }
                }).catch(errors => {
                    // Handle error
                    showToast(toastContainer, errors.response.data.message, 'red');
                });
                addEmployeeForm.reset();
            });

            // Logout
            const logout = document.getElementById('logout');
            logout.addEventListener('click', (e) => {
                const accessToken = JSON.parse(localStorage.getItem('access_token'));

                // Import it from loaderBtn.js
                loadBtn(logout, 'text-light'); // Load btn

                const headers = {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'application/json'
                };

                axios.post('/api/logout', null, {
                    headers
                }).then(({
                    data
                }) => {
                    if (data.status === 'success') {
                        localStorage.removeItem('access_token');
                        window.location.href = '/login';

                        loadBtn(logout, '', 'Logout', false); // Unload the btn
                    }
                });
            });
        });
    </script>
@endsection
