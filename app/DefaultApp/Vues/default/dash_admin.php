
<div class="form-head d-flex mb-3 mb-md-5 align-items-start flex-wrap justify-content-between">
    <div class="me-auto d-lg-block">
        <h3 class="text-primary font-w600">Welcome to Mediqu!</h3>
        <p class="mb-0">Hospital Admin Dashboard Template</p>
    </div>
    <form class="default-search">
        <div class="input-group search-area ms-auto w-100 d-inline-flex">
            <input type="text" class="form-control" placeholder="Search here">
            <span class="input-group-text"><button class="bg-transparent border-0"><i class="flaticon-381-search-2"></i></button></span>
        </div>
    </form>

</div>
<div class="row">
    <div class="col-xl-6 col-xxl-6">
        <div class="row">
            <!-- <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12"> -->
            <div class="col-xl-6 col-xxl-12 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Recovered</h4>
                        <div class="dropdown ms-auto c-pointer">
                            <div class="btn-link" data-bs-toggle="dropdown">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div class="recovered-chart-deta d-flex flex-wrap">
                            <div class="col mb-3">
                                <span class="bg-danger"></span>
                                <div>
                                    <p>New</p>
                                    <h5>451</h5>
                                </div>
                            </div>
                            <div class="col mb-3">
                                <span class="bg-success"></span>
                                <div>
                                    <p>Recovered</p>
                                    <h5>623</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 px-3 pb-0">
                        <div id="chartTimeline"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-12 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Visitors</h4>
                        <div class="dropdown ms-auto c-pointer">
                            <div class="btn-link" data-bs-toggle="dropdown">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-3 pt-2 pb-0">
                        <div id="chartStrock"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Patients (%)</h4>
                        <select class="default-select style-1" aria-label="Default select example">
                            <option selected>Monthly</option>
                            <option value="1">Weekly</option>
                            <option value="2">Daily</option>
                        </select>
                    </div>
                    <div class="card-body pt-2">
                        <h4 class="text-dark font-w400">Total Patient</h4>
                        <h3 class="text-primary font-w600">562,084 People</h3>
                        <div class="row mx-0 align-items-center">
                            <div class="col-sm-8 col-md-7  px-0 col-xxl-12">
                                <div id="chartCircle"></div>
                            </div>
                            <div class="col-sm-4 col-md-5 px-0 col-xxl-12">
                                <div class="patients-chart-deta">
                                    <div class="col px-0">
                                        <span class="bg-danger"></span>
                                        <div>
                                            <p>New</p>
                                            <h3>60%</h3>
                                        </div>
                                    </div>
                                    <div class="col px-0">
                                        <span class="bg-success"></span>
                                        <div>
                                            <p>Recovered</p>
                                            <h3>30%</h3>
                                        </div>
                                    </div>
                                    <div class="col px-0">
                                        <span class="bg-warning"></span>
                                        <div>
                                            <p>Treatment</p>
                                            <h3>20%</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Recent Patient Activity</h4>
                        <div class="dropdown ms-auto c-pointer">
                            <div class="btn-link" data-bs-toggle="dropdown">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table patient-activity flex-nowrap">
                                <tr>
                                    <td>
                                        <div class="media align-items-center">
                                            <img class="me-3 img-fluid rounded" width="78" src="assets/images/avatar/1.jpg" alt="DexignZone">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1">Media heading</h5>
                                                <p class="mb-0">41 Years Old</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Disease</p>
                                        <h5 class="my-0 text-primary">Allergies & Asthma</h5>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1">Status</p>
                                                <h5 class="mt-0 mb-1 text-success">Recovered</h5>
                                                <small>22/03/2021 12:34 AM</small>
                                            </div>
                                            <div class="dropdown ms-auto">
                                                <div class="btn-link" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end" >
                                                    <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="media align-items-center flex-wrap">
                                            <img class="me-3 img-fluid rounded" width="78" src="assets/images/avatar/2.jpg" alt="DexignZone">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1">Angela Nurhayati</h5>
                                                <p class="mb-0">21 Years Old</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Disease</p>
                                        <h5 class="my-0 text-primary">Sleep Problem</h5>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1">Status</p>
                                                <h5 class="mt-0 mb-1 text-danger">New Patient</h5>
                                                <small>22/03/2021 12:34 AM</small>
                                            </div>
                                            <div class="dropdown ms-auto">
                                                <div class="btn-link" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="active">
                                    <td>
                                        <div class="media align-items-center flex-wrap">
                                            <img class="me-3 img-fluid rounded" width="78" src="assets/images/avatar/3.jpg" alt="DexignZone">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1">James Robinson</h5>
                                                <p class="mb-0">25 Years Old</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Disease</p>
                                        <h5 class="my-0 text-primary">Dental Care</h5>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1">Status</p>
                                                <h5 class="mt-0 mb-1 text-warning">Treatment</h5>
                                                <small>22/03/2021 12:34 AM</small>
                                            </div>
                                            <div class="dropdown ms-auto">
                                                <div class="btn-link" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="media align-items-center flex-wrap">
                                            <img class="me-3 img-fluid rounded" width="78" src="assets/images/avatar/4.jpg" alt="DexignZone">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1">Thomas Jaja</h5>
                                                <p class="mb-0">7 Years Old</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Disease</p>
                                        <h5 class="my-0 text-primary">Diabetes</h5>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1">Status</p>
                                                <h5 class="mt-0 mb-1 text-danger">New Patient</h5>
                                                <small>22/03/2021 12:34 AM</small>
                                            </div>
                                            <div class="dropdown ms-auto">
                                                <div class="btn-link" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="media align-items-center flex-wrap">
                                            <img class="me-3 img-fluid rounded" width="78" src="assets/images/avatar/5.jpg" alt="DexignZone">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1">Cindy Brownleee</h5>
                                                <p class="mb-0">71 Years Old</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Disease</p>
                                        <h5 class="my-0 text-primary">Covid-19 Suspect</h5>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1">Status</p>
                                                <h5 class="mt-0 mb-1 text-success">Recovered</h5>
                                                <small>22/03/2021 12:34 AM</small>
                                            </div>
                                            <div class="dropdown ms-auto">
                                                <div class="btn-link" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="media align-items-center flex-wrap">
                                            <img class="me-3 img-fluid rounded" width="78" src="assets/images/avatar/6.jpg" alt="DexignZone">
                                            <div class="media-body">
                                                <h5 class="mt-0 mb-1">Oconner Jr.</h5>
                                                <p class="mb-0">17 Years Old</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0">Disease</p>
                                        <h5 class="my-0 text-primary">Dental Care</h5>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1">Status</p>
                                                <h5 class="mt-0 mb-1 text-warning">Treatment</h5>
                                                <small>22/03/2021 12:34 AM</small>
                                            </div>
                                            <div class="dropdown ms-auto">
                                                <div class="btn-link" data-bs-toggle="dropdown">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="12" cy="5" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="19" r="2"></circle></g></svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="javascript:void(0);">Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-0 pt-0 text-center">
                        <a href="javascript:void(0);" class="btn-link">See More >></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-xxl-6">
        <div class="row">
            <div class="col-xl-6 col-lg-6  col-xxl-12 col-sm-6">
                <div class="app-stat card bg-danger">
                    <div class="card-body  p-4">
                        <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-calendar-1"></i>
											</span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1">Appointment</p>
                                <h2 class="text-white">76</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-xxl-12 col-sm-6">
                <div class="app-stat card bg-success">
                    <div class="card-body p-4">
                        <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-diamond"></i>
											</span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1 text-nowrap">Hospital Earning</p>
                                <h2 class="text-white">$56K</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="app-stat card bg-info">
                    <div class="card-body p-4">
                        <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-heart"></i>
											</span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1 text-nowrap">Total Patient</p>
                                <h2 class="text-white">783K</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="app-stat card bg-primary">
                    <div class="card-body p-4">
                        <div class="media flex-wrap">
											<span class="me-3">
												<i class="flaticon-381-user-7"></i>
											</span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1">Operations</p>
                                <h2 class="text-white">76</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Revenue</h4>
                        <select class="default-select style-1" aria-label="Default select example">
                            <option selected>2022</option>
                            <option value="1">2023</option>
                            <option value="2">2024</option>
                        </select>
                    </div>
                    <div class="card-body pt-2">
                        <h3 class="text-primary font-w600">$41,512k <small class="text-dark ms-2">$25,612k</small></h3>
                        <div id="chartBar"></div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="card-title">Top 5 Best Doctor</h4>
                        <a class="btn-link ms-auto" href="javascript:void(0);">More >></a>
                    </div>
                    <div class="card-body">
                        <div class="widget-media best-doctor">
                            <ul class="timeline">
                                <li>
                                    <div class="timeline-panel d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="d-flex">
                                            <div class="media me-4">
                                                <img alt="image" width="90" src="assets/images/avatar/1.jpg">
                                                <div class="number">#1</div>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="mb-2">Dr. Samantha Queque</h4>
                                                <p class="mb-2 text-primary">Gynecologist</p>
                                                <div class="star-review">
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-gray"></i>
                                                    <i class="fa fa-star text-gray"></i>
                                                    <span class="ms-3">451 reviews</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="social-media">
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-instagram"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-twitter"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-facebook-f"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel active d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="d-flex">
                                            <div class="media me-4">
                                                <img alt="image" width="90" src="assets/images/avatar/2.jpg">
                                                <div class="number">#2</div>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="mb-2">Dr. Abdul Aziz Lazis</h4>
                                                <p class="mb-2 text-primary">Physical Therapy</p>
                                                <div class="star-review">
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-gray"></i>
                                                    <span class="ms-3">238 reviews</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="social-media">
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-instagram"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-twitter"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-facebook-f"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="d-flex">
                                            <div class="media me-4">
                                                <img alt="image" width="90" src="assets/images/avatar/3.jpg">
                                                <div class="number">#3</div>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="mb-2">Dr. Samuel Jr.</h4>
                                                <p class="mb-2 text-primary">Dentist</p>
                                                <div class="star-review">
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-gray"></i>
                                                    <i class="fa fa-star text-gray"></i>
                                                    <span class="ms-3">300 reviews</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="social-media">
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-instagram"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-twitter"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-facebook-f"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="d-flex">
                                            <div class="media me-4">
                                                <img alt="image" width="90" src="assets/images/avatar/4.jpg">
                                                <div class="number">#4</div>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="mb-2">Dr. Alex Siauw</h4>
                                                <p class="mb-2 text-primary">Physical Therapy</p>
                                                <div class="star-review">
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-gray"></i>
                                                    <i class="fa fa-star text-gray"></i>
                                                    <span class="ms-3">451 reviews</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="social-media">
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-instagram"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-twitter"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-facebook-f"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline-panel d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="d-flex">
                                            <div class="media me-4">
                                                <img alt="image" width="90" src="assets/images/avatar/5.jpg">
                                                <div class="number">#5</div>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="mb-2">Dr. Jennifer Ruby</h4>
                                                <p class="mb-2 text-primary">Nursingc</p>
                                                <div class="star-review">
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <i class="fa fa-star text-orange"></i>
                                                    <span class="ms-3">700 reviews</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="social-media">
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-instagram"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-twitter"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary btn-rounded btn-sm"><i class="fab fa-facebook-f"></i></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer border-0 pt-0 text-center">
                        <a href="javascript:void(0);" class="btn-link">See More >></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
