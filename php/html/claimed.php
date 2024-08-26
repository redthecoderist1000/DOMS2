<?php
session_start();
$_SESSION['currentpage'] = "lost";
$username = $_SESSION['username'];
include("../database/database_conn.php");
include('php/fetch_student_data.php');

//count surrender data
$query_count_surrender = "SELECT COUNT(*) AS count FROM lost_found_db WHERE status = 'surrender'";
$result_count_surrender = mysqli_query($conn, $query_count_surrender);
$row_count_surrender = mysqli_fetch_assoc($result_count_surrender);
$surrender_count = $row_count_surrender['count'];

//count claim data
$query_count_claim = "SELECT COUNT(*) AS count FROM lost_found_db WHERE status = 'claimed'";
$result_count_claim = mysqli_query($conn, $query_count_claim);
$row_count_claim = mysqli_fetch_assoc($result_count_claim);
$claim_count = $row_count_claim['count'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/DOMS_logo.png" type="image/x-icon">
    <title>Lost & Found</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/lost.css">
    <link rel="stylesheet" href="sidenav/sidenav.css">
    <link rel="stylesheet" href="../css/general.css">
    <script src="js/screen_timeout.js"></script>

</head>

<body>

    <div class="sidenav">
        <?php
        include('sidenav/sidenav.php');
        ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const headerBtn = document.querySelector('.header-btn');
            const sidenavBtn = document.querySelector('.sidenav-btn');
            const sidenav = document.querySelector('.sidenav');

            headerBtn.addEventListener('click', () => {
                sidenav.classList.toggle('active');
            });

            sidenavBtn.addEventListener('click', () => {
                sidenav.classList.toggle('active');
            });
        });
    </script>

    <div class="header-btn">
        <i class="fas fa-bars"></i>
    </div>

    <section class="main-do">

        <div class="body-content">

            <div class="title-page">
                <h1>Lost & Found</h1>
                <hr>
            </div>

            <div class="filter-group">
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="dropdowns">

                    <select name="" id="">
                        <option value="" style="display: none;" selected>Item</option>
                        <option value=""></option>
                        <option value=""></option>
                    </select>

                    <span><i class="fa-solid fa-filter"></i> Date filter</span>

                </div>
            </div>

            <!-- Modal DATE -->
            <div id="dateModal" class="modal-date">
                <div class="modal-content-date">

                    <span class="close-date">&times;</span>

                    <div class="date-header">
                        <h2>FILTER DATE</h2>
                    </div>

                    <div class="modal-date-details">

                        <div class="input-date">
                            <label for="from">From</label>
                            <input type="date" name="from">
                        </div>

                        <div class="input-date">
                            <label for="to">To</label>
                            <input type="date" name="to">
                        </div>


                        <button>APPLY FILTER</button>
                    </div>

                </div>
            </div>

            <script>
                var modaldate = document.getElementById("dateModal");

                var btndate = document.querySelector(".dropdowns span");

                var spandate = document.getElementsByClassName("close-date")[0];

                btndate.onclick = function() {
                    modaldate.style.display = "block";
                }

                spandate.onclick = function() {
                    modaldate.style.display = "none";
                }

                window.onclick = function(event) {
                    if (event.target == modaldate) {
                        modaldate.style.display = "none";
                    }
                }
            </script>

            <div class="table-nav">
                <div class="nav-list">
                    <ul>
                        <a href="#" style="border-bottom: solid 3px rgb(98, 130, 172)">
                            <li>CLAIMED ITEM <span><?php echo $claim_count ?></span></li>
                        </a>
                        <a href="lost.php">
                            <li>SURRENDERED ITEM <span><?php echo $surrender_count ?></span></li>
                        </a>
                        <a href="summary.php">
                            <li>SUMMARY REPORT</li>
                        </a>
                    </ul>
                </div>
                <div class="add-btn">
                    <span><i class="fa-solid fa-plus"></i> ADD</span>
                </div>
            </div>

            <div class="body-table">
                <table>
                    <thead>
                        <th>ITEM</th>
                        <th>DATE LOST</th>
                        <th>DATE CLAIMED</th>
                        <th>OWNER NAME</th>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM lost_found_db WHERE status = 'claimed'";
                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $lost_found_id = $row['lost_found_id'];
                                $student_id_surrender = $row['student_id_surrender'];
                                $student_id_owner = $row['student_id_owner'];

                                $item_type = $row['item_type'];
                                $loc_found = $row['loc_found'];
                                $item_img = $row['item_img'];
                                $description = $row['description'];
                                $date_surrender = $row['date_surrender'];
                                $date_claim = $row['date_claim'];

                                echo '
                    <tr class="item-row" data-lost-found-id="' . $lost_found_id . '">
                        <td>' . $item_type . '</td>
                        <td>' . $date_surrender . '</td>
                        <td>' . $date_claim . '</td>

                        <td>' . $student_id_owner . '</td>
                    </tr>
                    ';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal ITEM -->
            <div id="itemModal" class="modal-item">
                <div class="modal-content-item">
                    <div class="modal-body">
                        <div class="modal-img">
                            <img src="../images/logo.webp" alt="">
                        </div>

                        <hr>

                        <div class="modal-details">
                            <div class="details-header">
                                <h3>Owner Information</h3>
                            </div>
                            <div class="details-body">
                                <div class="input-wrap">
                                    <label>Student Name:</label>
                                    <p id="">Avril Belisario</p>
                                </div>
                                <div class="input-wrap">
                                    <label>Student ID:</label>
                                    <p id="">2021 190723</p>
                                </div>
                                <div class="input-wrap">
                                    <label>Email Address:</label>
                                    <p id="student_email">beliserio@students.nu-dasma.edu.ph</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="modal-details">
                            <div class="details-header">
                                <h3>Founder Information</h3>
                            </div>
                            <div class="details-body">
                                <div class="input-wrap">
                                    <label>Student Name:</label>
                                    <p id="">Avril Belisario</p>
                                </div>
                                <div class="input-wrap">
                                    <label>Student ID:</label>
                                    <p id="">2021 190723</p>
                                </div>
                                <div class="input-wrap">
                                    <label>Email Address:</label>
                                    <p id="student_email">beliserio@students.nu-dasma.edu.ph</p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="modal-details">
                            <div class="details-header">
                                <h3>Item Information</h3>
                            </div>
                            <div class="details-body">
                                <div class="input-wrap">
                                    <label>Item Brand:</label>
                                    <p id="">Fibrella</p>
                                </div>
                                <div class="input-wrap">
                                    <label>Item Color:</label>
                                    <p id="">Black</p>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="modal-buttons">
                                <span class="close" id="close">Cancel</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var modal = document.getElementById("itemModal");
                    var btns = document.querySelectorAll('.item-row');
                    var span = document.getElementById("close");

                    btns.forEach(function(btn) {
                        btn.onclick = function() {
                            modal.style.display = "block";
                        };
                    });

                    span.onclick = function() {
                        modal.style.display = "none";
                    };

                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    };
                });
            </script>

            <!-- Modal ADD -->
            <div id="addModal" class="modal-add">
                <div class="modal-content-add">

                    <span class="close-add">&times;</span>

                    <div class="add-header">
                        <h1>Add Item</h1>
                    </div>

                    <form action="php/insert_item_data.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body-add">
                            <div class="modal-body1">

                                <div class="input-wrap2">
                                    <label for="student-id">Student ID:</label>
                                    <input type="text" name="student-id">
                                </div>

                                <div class="input-wrap2">
                                    <label for="item-type">Item Type:</label>
                                    <input type="text" name="item-type">
                                </div>

                                <div class="input-wrap2">
                                    <label for="item-found">Item Found:</label>
                                    <input type="text" name="item-found">
                                </div>

                                <div class="modal-desc">
                                    <label for="description">Description:</label>
                                    <textarea name="description" id=""></textarea>
                                </div>

                            </div>

                            <div class="modal-body2">
                                <div class="image-container" id="images"></div>
                                <div class="upload-button">
                                    <input type="file" id="file-input" accept="image/png, image/jpeg">
                                    <label for="file-input"><i class="fas fa-upload"></i> Upload</label>
                                </div>
                            </div>

                            <script>
                                document.getElementById('file-input').addEventListener('change', function(event) {
                                    const imageContainer = document.getElementById('images');
                                    const files = event.target.files;

                                    for (let i = 0; i < files.length; i++) {
                                        const file = files[i];
                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            const imgElement = document.createElement('img');
                                            imgElement.src = e.target.result;
                                            imageContainer.appendChild(imgElement);
                                        };

                                        reader.readAsDataURL(file);
                                    }
                                });
                            </script>

                        </div>
                        <div class="modal-form-btn">
                            <button type="submit">SUBMIT</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <script>
            var modal2 = document.getElementById("addModal");

            var btn2 = document.querySelector(".add-btn span");

            var span2 = document.getElementsByClassName("close-add")[0];

            btn2.onclick = function() {
                modal2.style.display = "block";
            }

            span2.onclick = function() {
                modal2.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal2) {
                    modal2.style.display = "none";
                }
            }
        </script>




        </div>

    </section>

    <script src="../javascript/profile.js"></script>
</body>

</html>