<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    #toggle_input {
        padding:4px 4px;
        background-color: #3498db;
        color: #fff;
        border: none;
        cursor: pointer;
        margin: -3rem 0;
    }


    .timestamp {
        font-size: 0.8em; /* Adjust the font size as needed */
        color: #888; /* Adjust the color as needed */

    }

</style>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Montserrat'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
    <link rel="stylesheet" href="{{ asset('css/chats.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <div id="app" >
        <div class="container" >
            <div class="row">
            <nav class="menu">
                <ul class="items">
                <li class="item"><i class="fa fa-home" aria-hidden="true"></i></li>
                <li class="item"><i class="fa fa-user" aria-hidden="true"></i></li>
                <li class="item"><i class="fa fa-pencil" aria-hidden="true"></i></li>
                <li class="item item-active"><i class="fa fa-commenting" aria-hidden="true"></i></li>
                <li class="item"><i class="fa fa-file" aria-hidden="true"></i></li>
                <li class="item"><i class="fa fa-cog" aria-hidden="true"></i></li>
                </ul>
            </nav>
            <chat-component></chat-component>

            <section class="discussions">
                <div class="discussion search">
                <div class="searchbar"><i class="fa fa-search" aria-hidden="true"></i>
                    <input type="text" placeholder="Search...">
                </div>
                </div>


                @foreach ($users as $item )
                    <a href="{{route('chats.show',$item->id)}}" class="discussion {{$item->id==$user->id?'message-active':''}}">
                            <div class="photo" style="background-image: url(https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png);">
                                <div class="online"></div>
                            </div>
                            <div class="desc-contact">
                                <p class="name">{{$item->name}}</p>
                                <p class="message">{{$item->email}}</p>
                            </div>
                    </a>
                @endforeach
            </section>
                <section class="chat">
                    <div class="header-chat">
                        <i class="icon fa fa-user-o" aria-hidden="true"></i>
                        <p class="name">Chat Task</p>
                        <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
                    </div>

                    <div class="messages-chat" id="new_message">
                        @foreach ($chat->messages as $message)
                            @if($message->sender != auth()->user()->id)
                                <div class="message">
                                    <div class="photo" style="background-image: url(https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png);">
                                        <div class="online"></div>
                                    </div>
                                    @if($message->file)

                                        @if(pathinfo($message->file, PATHINFO_EXTENSION) === 'jpg' || pathinfo($message->file, PATHINFO_EXTENSION) === 'png' || pathinfo($message->file, PATHINFO_EXTENSION) === 'jpeg' || pathinfo($message->file, PATHINFO_EXTENSION) === 'gif')
                                            <!-- Display image if the file is an image -->
                                            <img src="{{ asset('storage/uploads/' . $message->file) }}" alt="{{ $message->file }}" style="max-width: 100%; max-height: 200px;">
                                            <span class="timestamp d-block">    {{ $message->created_at->diffForHumans() }}</span> <!-- Displaying timestamp -->

                                        @else
                                            <!-- Provide download link for other types of files -->
                                            <p class="text">
                                                <a href="{{ asset('storage/uploads/' . $message->file) }}" download="{{ $message->file }}">{{ $message->file }}</a>
                                                <span class="timestamp d-block">    {{ $message->created_at->diffForHumans() }}</span> <!-- Displaying timestamp -->

                                            </p>

                                        @endif


                                @else
                                        <p class="text"> {{ $message->body }}
                                        <span class="timestamp d-block">    {{ $message->created_at->diffForHumans() }}</span> <!-- Displaying timestamp -->
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div class="message text-only">
                                    <div class="response">
                                        @if($message->file)
                                            @if(pathinfo($message->file, PATHINFO_EXTENSION) === 'jpg' || pathinfo($message->file, PATHINFO_EXTENSION) === 'png' || pathinfo($message->file, PATHINFO_EXTENSION) === 'jpeg' || pathinfo($message->file, PATHINFO_EXTENSION) === 'gif')
                                                <!-- Display image if the file is an image -->
                                                <img src="{{ asset('storage/uploads/' . $message->file) }}" alt="{{ $message->file }}" style="max-width: 100%; max-height: 200px;">
                                                <span class="timestamp d-block">    {{ $message->created_at->diffForHumans() }}</span> <!-- Displaying timestamp -->

                                            @else
                                                <!-- Provide download link for other types of files -->
                                                <p class="text">
                                                    <a href="{{ asset('storage/uploads/' . $message->file) }}" download="{{ $message->file }}">{{ $message->file }}</a>
                                                    <span class="timestamp d-block">    {{ $message->created_at->diffForHumans() }}</span> <!-- Displaying timestamp -->

                                                </p>
                                            @endif
                                        @else
                                            <p class="text"> {{ $message->body }}
                                      <span class="timestamp d-block">    {{ $message->created_at->diffForHumans() }}</span> <!-- Displaying timestamp -->
                                                @if(isset($message->received_at) &&$message->received_at !=null )
                                      <span class="timestamp d-block">  Received At:  {{ $message->received_at }}</span> <!-- Displaying timestamp -->
                                                @endif
                                            </p>

                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>

                    <div class="footer-chat">
                        <input type="hidden" id="chat_id" value="{{ $chat->id }}">
                        <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">

                        <div class="message-options">
                            <i class="icon fa fa-smile-o clickable" style="font-size:25pt;" aria-hidden="true"></i>
                            <input type="text" id="message_input" class="write-message" placeholder="Type your message here">
                            <input type="file" id="file_input" class="file-input" accept="image/*, .pdf, .doc, .docx">
                            <i class="icon send fa fa-paper-plane-o clickable" id="send_icon" aria-hidden="true"></i>
                            <button id="toggle_input">Send File</button> <!-- Add button to toggle between text and file inputs -->
                        </div>

                    </div>
                </section>

            </div>
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {
        $("#send_icon").click(function () {
            var chat_id = document.getElementById('chat_id').value;
            var user_id = document.getElementById('user_id').value;
            var body = document.getElementById("message_input").value;

            var fileInput = document.getElementById('file_input');
            var file = fileInput.files[0];

            if ((body && body.trim() !== '') || (file && file !== '')) {
                var formData = new FormData();
                formData.append('chat_id', chat_id);
                formData.append('user_id', user_id);
                formData.append('body', body.trim());
                formData.append('file', file);

                async function postData(url = '{{route('message.store')}}', data) {
                    const response = await fetch(url, {
                        method: 'POST',
                        mode: 'cors',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        body: data
                    });
                    return response.json();
                }

                postData('{{route('message.store')}}', formData).then((data) => {
                    // Clear text input
                    document.getElementById("message_input").value = '';


                });
            }
        });

        // Add click event to switch between text and file inputs
        $("#file_input").hide();
        $("#toggle_input").click(function () {
            // Clear values on toggle
            document.getElementById("message_input").value = '';
            document.getElementById("file_input").value = '';

            // Toggle between text and file inputs
            $("#message_input").toggle();
            $("#file_input").toggle();

            // Change text based on selected input
            var buttonText = $("#message_input").is(":visible") ? "Send File" : "Send Text";
            $("#toggle_input").text(buttonText);
        });
    });
</script>
