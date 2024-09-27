<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Review Page</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include FontAwesome for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    .star-light {
        color: #e4e5e9;
    }

    .text-warning {
        color: #ffc107;
    }

    .progress-bar {
        background-color: #ffc107;
    }

    .modal-content {
        border-radius: 10px;
    }

    .card {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header" id="product_title">Product Title</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3 text-center">
                        <img id="product_image" src="" alt="Product Image" width="230">
                        <button type="button" name="add_review" id="add_review"
                            class="btn btn-primary form-control mt-3">Rate/Review This Product</button>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                            <b><span id="average_rating">0.0</span> / 5</b>
                        </h1>
                        <div class="mb-3">
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                        </div>
                        <h3><span id="total_review">0</span> Reviews</h3>
                    </div>
                    <div class="col-sm-4">
                        <div class="mb-2">
                            <span class="text-warning">5 Star</span>
                            <div class="progress">
                                <div class="progress-bar" id="five_star_progress" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-warning">4 Star</span>
                            <div class="progress">
                                <div class="progress-bar" id="four_star_progress" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-warning">3 Star</span>
                            <div class="progress">
                                <div class="progress-bar" id="three_star_progress" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-warning">2 Star</span>
                            <div class="progress">
                                <div class="progress-bar" id="two_star_progress" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="text-warning">1 Star</span>
                            <div class="progress">
                                <div class="progress-bar" id="one_star_progress" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="mt-3 ml-4">Product Reviews:</h3>
        <div class="mt-3" id="review_content"></div>
    </div>

    <!-- Review Modal -->
    <div id="review_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center mt-2 mb-4">
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <div class="form-group">
                        <label for="">Your Name:</label>
                        <input type="text" name="user_name" id="user_name" class="form-control"
                            placeholder="Enter Your Name" />
                    </div>
                    <div class="form-group">
                        <label for="">Comment:</label>
                        <textarea name="user_review" id="user_review" class="form-control"
                            placeholder="Type Review Here"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include FontAwesome for star icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <script>
    $(document).ready(function() {
        var rating_data = 0;
        var product_id =
            1; // ID-ul produsului, îl poți modifica în funcție de produsul pe care vrei să-l afișezi
        var token =
            'e4c867603e15caf2e4dd1c9c8a4bec1392114bf05f708ed769d401bc5bc7b44087560011af4b58604394f6b50589ab6ee9f99c9cd10a4ddf01781345a875de40a67a795b356104dbd271df76c472780bd9c75d62fb1d1b59f629a0f055121194153a94ac0201d184108b859f1e5b38305868f1e2458af287e5f36c34d9007ff6';

        $('#add_review').click(function() {
            $('#review_modal').modal('show');
        });

        function reset_background() {
            for (var count = 1; count <= 5; count++) {
                $('#submit_star_' + count).addClass('star-light');
                $('#submit_star_' + count).removeClass('text-warning');
            }
        }

        $(document).on('mouseenter', '.submit_star', function() {
            var rating = $(this).data('rating');
            reset_background();
            for (var count = 1; count <= rating; count++) {
                $('#submit_star_' + count).addClass('text-warning');
            }
        });

        $(document).on('mouseleave', '.submit_star', function() {
            reset_background();
            for (var count = 1; count <= rating_data; count++) {
                $('#submit_star_' + count).removeClass('star-light');
                $('#submit_star_' + count).addClass('text-warning');
            }
        });

        $(document).on('click', '.submit_star', function() {
            rating_data = $(this).data('rating');
        });

        $('#save_review').click(function() {
            var user_name = $('#user_name').val();
            var user_review = $('#user_review').val();

            if (user_name != '' && user_review != '' && rating_data > 0) {
                $.ajax({
                    url: 'http://localhost:1337/reviews', // Endpoint-ul pentru recenzii
                    method: 'POST',
                    headers: {
                        'Authorization': token // Adaugă Bearer token în header
                    },
                    data: {
                        product_id: product_id,
                        rating: rating_data,
                        user_name: user_name,
                        user_review: user_review
                    },
                    success: function(data) {
                        $('#review_modal').modal('hide');
                        load_review_data();
                    }
                });
            } else {
                alert("Please fill in all fields and give a rating.");
            }
        });

        function load_review_data() {
            $.ajax({
                url: 'http://localhost:1337/products/' + product_id + '?populate=*',
                method: 'GET',
                headers: {
                    'Authorization': token // Adaugă Bearer token în header
                },
                success: function(data) {
                    $('#product_title').text(data.title);
                    $('#product_image').attr('src', data.image.url);
                    $('#average_rating').text(data.average_rating);
                    $('#total_review').text(data.total_reviews);

                    var review_data = '';
                    for (var count = 0; count < data.reviews.length; count++) {
                        review_data += '<div class="card">';
                        review_data += '<div class="card-body">';
                        review_data += '<h5>' + data.reviews[count].user_name + '</h5>';
                        review_data += '<p>' + data.reviews[count].review + '</p>';
                        review_data += '<p>Rating: ' + data.reviews[count].rating + ' / 5</p>';
                        review_data += '</div>';
                        review_data += '</div>';
                    }

                    $('#review_content').html(review_data);
                }
            });
        }

        load_review_data();
    });
    </script>
</body>

</html>