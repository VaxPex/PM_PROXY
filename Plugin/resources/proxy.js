process.env.DEBUG = 'minecraft-protocol' // debugmode

const { Relay } = require("bedrock-protocol");

let proxy_address = '';
let proxy_port = 19132;

const proxy = new Relay({
    host: "0.0.0.0",
    port: 19133,
    version: "1.18.11",
    destination: {
        host: proxy_address,
        port: proxy_port
    }
});
proxy.listen();

proxy.on("connect", player => {
    player.on("serverbound", ({name, params}) => {
        if(name === "text"){
            params.message = "hehe"
        }
        console.log(name);
    });
});
