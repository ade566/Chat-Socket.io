const { log } = require('console');
const express = require('express');

const app = express();

const server = require('http').createServer(app)

const io = require('socket.io')(server, {
    cors: {
        origin: "*"
    }
})

io.on('connection', (socket) => {
    var as = socket.handshake.query.name ?? ''

    console.log('connection', as);

    io.sockets.emit('loadChat', {
        message: [
            {message: 'Hai', sender:'ade'},
            {message: 'Hai juga', sender:'mila'},
        ],
        as
    })

    socket.on('sendChatToServer', (e) => {
        io.sockets.emit('sendChatToClient', e)
    })

    socket.on('disconnect', (socket) => {
        console.log('disconnect');
    })
})

server.listen(3000, () => {
    console.log('start server');
})