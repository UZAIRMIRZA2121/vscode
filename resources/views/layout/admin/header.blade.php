<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('frontend-asset/img/logo.png') }}">
    <title>Admin Dashboard</title>
  
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Include jQuery -->

    <!-- Custom CSS -->
    <style>
        /* Sidebar styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px; /* Adjust as needed */
            background-color: #343a40;
            padding-top: 3rem; /* Adjust to leave space for top navigation */
        }
        .sidebar-brand {
            font-size: 1.5rem;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
            border-bottom: 1px solid #fff;
        }
        .nav-item {
            padding: 0.5rem;
        }
        .nav-link {
            color: #fff;
        }

        /* Main content styles */
        .main-content {
            margin-left: 250px; /* Sidebar width */
            padding: 20px; /* Adjust as needed */
        }.ag-format-container {
  width: 1142px;
  margin: 0 auto;
}


body {
  background-color: #fff;
}
.ag-courses_box {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;

  padding: 50px 0;
}
.ag-courses_item {
  -ms-flex-preferred-size: calc(33.33333% - 30px);
  flex-basis: calc(33.33333% - 30px);

  margin: 0 15px 30px;

  overflow: hidden;

  border-radius: 28px;
}
.ag-courses-item_link {
  display: block;
  padding: 30px 20px;
  background-color: #121212;

  overflow: hidden;

  position: relative;
}
.ag-courses-item_link:hover,
.ag-courses-item_link:hover .ag-courses-item_date {
  text-decoration: none;
  color: #FFF;
}
.ag-courses-item_link:hover .ag-courses-item_bg {
  -webkit-transform: scale(10);
  -ms-transform: scale(10);
  transform: scale(10);
}
.ag-courses-item_title {
  min-height: 87px;
  margin: 0 0 25px;

  overflow: hidden;

  font-weight: bold;
  font-size: 30px;
  color: #FFF;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date-box {
  font-size: 28px;
  color: #FFF;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date {
  font-weight: bold;
  color: #f9b234;

  -webkit-transition: color .5s ease;
  -o-transition: color .5s ease;
  transition: color .5s ease
}
.ag-courses-item_bg {
  height: 128px;
  width: 128px;
  background-color: #f9b234;

  z-index: 1;
  position: absolute;
  top: -75px;
  right: -75px;

  border-radius: 50%;

  -webkit-transition: all .5s ease;
  -o-transition: all .5s ease;
  transition: all .5s ease;
}
.ag-courses_item:nth-child(2n) .ag-courses-item_bg {
  background-color: #3ecd5e;
}
.ag-courses_item:nth-child(3n) .ag-courses-item_bg {
  background-color: #e44002;
}
.ag-courses_item:nth-child(4n) .ag-courses-item_bg {
  background-color: #952aff;
}
.ag-courses_item:nth-child(5n) .ag-courses-item_bg {
  background-color: #cd3e94;
}
.ag-courses_item:nth-child(6n) .ag-courses-item_bg {
  background-color: #4c49ea;
}



@media only screen and (max-width: 979px) {
  .ag-courses_item {
    -ms-flex-preferred-size: calc(50% - 30px);
    flex-basis: calc(50% - 30px);
  }
  .ag-courses-item_title {
    font-size: 24px;
  }
}

@media only screen and (max-width: 767px) {
  .ag-format-container {
    width: 96%;
  }

}
@media only screen and (max-width: 639px) {
  .ag-courses_item {
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
  }
  .ag-courses-item_title {
    min-height: 72px;
    line-height: 1;

    font-size: 24px;
  }
  .ag-courses-item_link {
    padding: 22px 40px;
  }
  .ag-courses-item_date-box {
    font-size: 24px;
  }
}

.sidebar-link
{
  display: none;
}
.prescription{
  margin-top: 87px;
}

/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
   .sidebar{
    display: none;
   }
   .main-content {
    margin-left: 0px;
   }
   .sidebar-link
{
  display: block;
}
.prescription{
  margin-top: 0px;
}
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 601px) and (max-width: 768px) {
  .sidebar{
    display: none;
   }
   .main-content {
    margin-left: 0px;
   }
   .sidebar-link
{
  display: block;
}
.prescription{
  margin-top: 0px;
}
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 769px) and (max-width: 992px) {
  .sidebar{
    display: none;
   }
   .main-content {
    margin-left: 0px;
   }
   .sidebar-link
{
  display: block;
}
.prescription{
  margin-top: 0px;
}
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 993px) and (max-width: 1200px) {
    /* CSS styles for large devices */
}

/* Extra large devices (large desktops, 1200px and up) */
@media only screen and (min-width: 1201px) {
    /* CSS styles for extra large devices */
}

    </style>
</head>
<body>