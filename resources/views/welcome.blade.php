<html>
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet" >
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" type="text/css" href="{{asset('css/chat.css')}}">
    </head>
    <body>
        <div class="container">
            <div class="messaging">
                <div class="inbox_msg">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4>Recent</h4>
                            </div>
                            <div class="srch_bar">
                                <div class="stylish-input-group">
                                    <input type="text" class="search-bar"  placeholder="Search" >
                                    <span class="input-group-addon">
                                    <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                                    </span> 
                                </div>
                            </div>
                        </div>
                        <div class="inbox_chat">
                            <div class="chat_list active_chat">
                                <div class="chat_people">
                                    <div class="chat_img"> 
                                        <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                                    </div>
                                    <div class="chat_ib">
                                        <h5>Mila Safitri <span class="chat_date">Dec 25</span></h5>
                                        <p id="inbox-mila">...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mesgs">
                        <div class="msg_history">
                            
                            
                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <input type="text" class="write_msg" style="outline: 0px" placeholder="Type a message" />
                                <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-center top_spac"> Design by <a target="_blank" href="https://www.linkedin.com/in/sunil-rajput-nattho-singh/">Sunil Rajput</a></p>
            </div>
        </div>

        <button onclick="myaddress(this)" data-ket="12121" data-id="1" class="btn btn-primary btn-sm">
            test 1
        </button>

        <button onclick="myaddress(this)" data-ket="12121" data-id="2" class="btn btn-primary btn-sm">
            test 2
        </button>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>

        <script>
            function myaddress(e) {
  console.log(e)
}

            /**
             * GET PARAMS
             **/
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const name = urlParams.get('name')
            
            let chatInput = $(`.write_msg`)

            $(document).ready(function() {
                let ipAddress = '127.0.0.1'
                let socketPort = '3000'

                let socket = io(ipAddress + ':' + socketPort + '/?name=' + name)

                chatInput.keypress(function(e) {
                    if (e.which === 13 && !e.shiftKey) {
                        sendChat()
                        return false
                    }
                })

                $(`.msg_send_btn`).on('click', function() {
                    sendChat()
                })

                socket.on('loadChat', (data) => {
                    if (data.as == name) {
                        data.message.forEach(e => {
                            renderChat(e)
                        });
                    }
                })

                socket.on('sendChatToClient', (e) => {
                    renderChat(e)
                })

                function sendChat()
                {
                    let message = chatInput.val()

                    if (!message) {
                        return false;
                    }

                    console.log(socket.emit('sendChatToServer', {
                        message,
                        sender: name
                    }));

                    chatInput.val('')
                }
            });

            function renderChat(e)
            {
                var bg = e.sender == name ? '#d2d6de' : '#007bff'
                var color = e.sender == name ? '#000' : '#fff'
                var align = e.sender == name ? 'right' : 'left'

                if (e.sender == name) {
                    $(`.msg_history`).append(`<div class="outgoing_msg">
                        <div class="sent_msg">
                            <p>${e.message}</p>
                            <span class="time_date"> 11:01 AM</span> 
                        </div>
                    </div>`)
                } else {
                    $(`.msg_history`).append(`<div class="incoming_msg">
                        <div class="incoming_msg_img"> 
                            <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                        </div>
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <p>${e.message}</p>
                                <span class="time_date"> 11:01 AM</span>
                            </div>
                        </div>
                    </div>`)
                }

                $(`#inbox-mila`).text(e.message)
            }
        </script>
    </body>
</html>