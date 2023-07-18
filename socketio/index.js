const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require('socket.io');
const io = new Server(server);

io.on('connection', (socket) => {
    console.log('a user connected');

    socket.on('disconnect', (socket) => {
        console.log('Disconnect');
    });
});

server.listen(3000, () => {
    console.log('Server is running ...');
});
