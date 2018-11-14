var mysql = require('mysql');
const TelegramBot = require('node-telegram-bot-api');
const config = require('./config');
var mysql = require('mysql');

var db_config = {
    host: 'localhost',
    user: 'admin_default',
    password: 'ouwe4f293t',
    database: 'admin_default',
    charset: 'utf8mb4'
};
require('http').createServer().listen(process.env.PORT || 5000).on('request', function(req, res) {
    res.end('')
});
/*var http = require("http");
setInterval(function() {
    http.get("http://magazinbot.herokuapp.com");
}, 300000);*/ // every 5 minutes (300000)
var connection;

function handleDisconnect() {
    connection = mysql.createConnection(db_config);
    connection.connect(function(err) {
        if (err) {
            console.log('Mazlumotlar bazasiga ulanishda xatolik bor:', err);
            setTimeout(handleDisconnect, 2000);
        }
    });

    connection.on('error', function(err) {
        if (err.code === 'PROTOCOL_CONNECTION_LOST') {
            handleDisconnect();
        } else {
            throw err;
        }
    });
}

handleDisconnect();
const bot = new TelegramBot(config.TOKEN, {
    polling: true
})

 

bot.on('message', msg => {
        var queryString = `SELECT 1 FROM tgusers WHERE tgid = '${msg.from.id}'`;
        connection.query(queryString, function(err, rows, fields) {
            if (err) throw err;

            if (rows.length === 0) {
                var sql = `INSERT INTO tgusers (username, tgid, tili) VALUES ('${msg.from.username}','${msg.from.id}','rus')`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                    var sql = `UPDATE tgusers SET step = "home" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });


                    bot.sendMessage(msg.chat.id, '🏫 Добро пожаловать в магазин!', {
                        reply_markup: {
                            "resize_keyboard": true,
                            keyboard: [
                                ["📋 Меню"],
                                ["📥 Корзина", "📳 Контакты"],
                                ["🚖 Оформить заказ"]
                            ]

                        }
                    });


                });

            }else{ 

        


        var queryString = `SELECT asos FROM tgusers WHERE tgid = '${msg.from.id}'`;
        connection.query(queryString, function(err, rows, fields) {
            if (err) throw err;
            if (rows[0].asos === '0') {

                switch (msg.text) {


                    
                    case `📋 Главное меню`:
                    

                        var sql = `UPDATE tgusers SET step = "home" WHERE tgid = "${msg.from.id}"`;
                        connection.query(sql, function(err, result) {
                            if (err) throw err;
                        });


                        bot.sendMessage(msg.chat.id, '🏫 Добро пожаловать в магазин!', {
                            reply_markup: {
                                "resize_keyboard": true,
                                keyboard: [
                                    ["📋 Меню"],
                                    ["📥 Корзина", "📳 Контакты"],
                                    ["🚖 Оформить заказ"]
                                ]

                            }
                        });



                        break;
                    case `📥 Корзина`:
                        var queryString = `SELECT nomi, dona, narxi FROM savat WHERE tgid = '${msg.from.id}' and xolati = 'yarmchala'`;
                        var jami = '';
                        var jnarxi = 0;
                connection.query(queryString, function(err, rows, fields) {
                    if (rows.length > 0){
                    for (i in rows){
                          jnarxi = rows[i].narxi * rows[i].dona + jnarxi;
                            jami = jami + `\n${rows[i].nomi} * ${rows[i].dona} = ${rows[i].narxi * rows[i].dona}`;

                    }
                    bot.sendMessage(msg.chat.id, `${jami}`);
                }else{
                     bot.sendMessage(msg.chat.id, `Продукт недостаточен`);
                }
                    
                

                });
                    break;
                    case `🚖 Оформить заказ`:
                    

                    
                    var queryString = `SELECT 1 FROM savat WHERE tgid = '${msg.from.id}' and xolati = 'yarmchala'`;
                connection.query(queryString, function(err, rows, fields) {
                    if (rows.length > 0){

                bot.sendMessage(msg.chat.id, 'вы бы это взяли? или мы пойдем', {
                    reply_markup: {
                        "resize_keyboard": true,
                        "one_time_keyboard": true,
                        keyboard: [
                            ["🏃 Самовывоз"],
                            ["🚖 Доставка"],
                            ["❌ Очистка"]
                        ]

                    }
                });
            
                var sql = `UPDATE tgusers SET asos = "2" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
            }else{
                bot.sendMessage(msg.chat.id,'Продукт недостаточен');
                var sql = `UPDATE tgusers SET asos = "0" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
            }
                });


                        break;
                   

                    case `📋 Меню`:
                        var sql = `UPDATE tgusers SET step = "menu" WHERE tgid = "${msg.from.id}"`;
                        connection.query(sql, function(err, result) {
                            if (err) throw err;
                        });

                        var queryString = `SELECT nomi FROM category WHERE parent = "home"`;
                        var a = [];
                        var b = [];
                        connection.query(queryString, function(err, rows, fields) {
                            if (err) throw err;
                            for (var i in rows) {
                                a[i] = [rows[i].nomi];
                            }
                            for (var q = 0; q < Math.floor(a.length / 2); q++) {
                                b[q] = a[q * 2].concat(a[q * 2 + 1]);
                            }
                            if (a.length % 2 == 1)
                                b.push(a[a.length - 1]);
                            b.push(["🚖 Оформить заказ"], ["📋 Главное меню", "📥 Корзина"]);
                            bot.sendMessage(msg.chat.id, 'Категории', {
                                reply_markup: {
                                    "one_time_keyboard": true,
                                    "resize_keyboard": true,
                                    keyboard: b
                                }
                            });
                        });
                        break;
                    case `📳 Контакты`:
                        var queryString = `SELECT nomi, manzili, telefoni FROM kontakt`;
                        connection.query(queryString, function(err, rows, fields) {
                            if (err) throw err;
                            for (i in rows) {
                                bot.sendMessage(msg.chat.id, `💸 Имя товара: ${rows[i].nomi} \n📤 Адрес: ${rows[i].manzili} \n🔎 Телефон: ${rows[i].telefoni}`)
                            }

                        });

                        break;
                 
                    default:


                        var queryString = `SELECT step FROM tgusers WHERE tgid = '${msg.from.id}'`;
                        connection.query(queryString, function(err, rows, fields) {
                            if (err) throw err;
                            if (rows.length > 0) {
                                var t = rows[0].step;
                            }
                            var queryString = `SELECT step FROM category WHERE nomi = '${msg.text}'`;
                            connection.query(queryString, function(err, rows2, fields) {
                                if (err) throw err;
                                if (rows2.length > 0) {
                                    if (rows2[0].step == 'last') {
                                        t = 'max';
                                    }
                                }
                                var queryString = `SELECT nomi FROM products WHERE nomi = '${msg.text}'`;
                                connection.query(queryString, function(err, rows3, fields) {
                                    if (err) throw err;
                                    var ty = 0;
                                    for (i in rows3) {
                                        if (rows3[i].nomi === msg.text) {
                                            ty = 1;
                                        }

                                    }
                                    if (ty === 1) {
                                        t = 'kir';
                                    }


                                    switch (t) {
                                        case 'menu':
                                            var queryString = `SELECT nomi FROM category WHERE parent = "${msg.text}"`;
                                            var a = [];
                                            var b = [];
                                            connection.query(queryString, function(err, rows, fields) {
                                                if (err) throw err;
                                                for (var i in rows) {
                                                    a[i] = [rows[i].nomi];
                                                }
                                                for (var q = 0; q < Math.floor(a.length / 2); q++) {
                                                    b[q] = a[q * 2].concat(a[q * 2 + 1]);
                                                }
                                                if (a.length % 2 == 1)
                                                    b.push(a[a.length - 1]);

                                                b.push(["📋 Главное меню"]);




                                                bot.sendMessage(msg.chat.id, 'Категории', {
                                                        reply_markup: {
                                                            "one_time_keyboard": true,
                                                            "resize_keyboard": true,
                                                            keyboard: b
                                                        }
                                                    }

                                                );
                                            });

                                            break;
                                        
                                        case 'max':
                                            var queryString = `SELECT nomi FROM products WHERE turi = "${msg.text}"`;
                                            var a = [];
                                            var b = [];
                                            connection.query(queryString, function(err, rows, fields) {
                                                if (err) throw err;
                                                for (var i in rows) {
                                                    a[i] = [rows[i].nomi];
                                                }
                                                for (var q = 0; q < Math.floor(a.length / 2); q++) {
                                                    b[q] = a[q * 2].concat(a[q * 2 + 1]);
                                                }
                                                if (a.length % 2 == 1)
                                                    b.push(a[a.length - 1]);
                                                b.push(["🚖 Оформить заказ"], ["📋 Главное меню", "📥 Корзина"]);




                                                bot.sendMessage(msg.chat.id, 'Категории', {
                                                        reply_markup: {
                                                            "one_time_keyboard": true,
                                                            "resize_keyboard": true,
                                                            keyboard: b
                                                        }
                                                    }

                                                );
                                            });
                                            break;
                                        case 'kir':
                                            var queryString = `SELECT tavfsiloti, rasmi, nomi, narxi FROM products WHERE nomi = '${msg.text}'`;
                                            connection.query(queryString, function(err, rows4, fields) {
                                                if (err) throw err;
                                                var rasmid = rows4[0].rasmi;

                                                var caption = `🎁 Имя товара: ${rows4[0].nomi} \n🎺 Цена ${rows4[0].narxi} сум \n📝 Описания ${rows4[0].tavfsiloti}`
                                                bot.sendPhoto(msg.chat.id, rasmid, {
                                                    caption: caption
                                                });
                                                var sql = `INSERT INTO savat (nomi, tgid, narxi, xolati) VALUES ('${msg.text}','${msg.from.id}','${rows4[0].narxi}','chala')`;

                                                connection.query(sql, function(err, result) {
                                                    if (err) throw err;
                                                  
                                                });
                                                bot.sendMessage(msg.chat.id, 'вы хотите купить? Сколько вам нужно? ', {
                                                    reply_markup: {
                                                        "resize_keyboard": true,
                                                        keyboard: [
                                                            ["1", "2", "3"],
                                                            ["4", "5", "6"],
                                                            ["7", "8", "9"],
                                                            ["Отменить заказ"]
                                                        ]

                                                    }
                                                })
                                            });
                                            var sql = `UPDATE tgusers SET asos = "1" WHERE tgid = "${msg.from.id}"`;
                                            connection.query(sql, function(err, result) {
                                                if (err) throw err;
                                            });
                                            break;
                                    }

                                });
                            });

                        });




                        break;

                }

            }

            if (rows[0].asos === '1') {

                if (msg.text === 'Отменить заказ'){
                    var sql = `DELETE FROM savat WHERE tgid = "${msg.from.id}" and xolati = "chala"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                     var sql = `UPDATE tgusers SET asos = "0" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
                    home(msg.chat.id);

                         
                }else{
                    var sql = `UPDATE savat SET dona = "${msg.text}" WHERE tgid = "${msg.from.id}" and xolati = "chala"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
                var queryString = `SELECT narxi FROM savat WHERE tgid = '${msg.from.id}'`;
                connection.query(queryString, function(err, rows, fields) {
                    if (err) throw err;
                    var sql = `UPDATE savat SET narxi = "${msg.text * rows[0].narxi}" WHERE tgid = "${msg.from.id}" and xolati = "chala"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                });


                var sql = `UPDATE savat SET xolati = "yarmchala" WHERE tgid = "${msg.from.id}" and xolati = "chala"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });

                     var sql = `UPDATE tgusers SET asos = "0" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });

               bot.sendMessage(msg.chat.id, 'Ваш заказ был помещен в корзину');
               home(msg.chat.id);
                
            }}
            if (rows[0].asos === '3') {


                var sql = `UPDATE savat SET ism = "${msg.text}" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
                var sql = `UPDATE tgusers SET asos = "4" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });


                var option = {
                    "parse_mode": "Markdown",
                    "reply_markup": {
                        "one_time_keyboard": true,
                        "keyboard": [
                            [{
                                text: "Отправить адрес",
                                request_location: true
                            }]
                        ]
                    }
                };


                var queryString = `SELECT manzil, telefon FROM savat WHERE tgid = '${msg.from.id}' and xolati = 'yarmchala'`;
                connection.query(queryString, function(err, rows, fields) {
                    if (err) throw err;
                    if (rows[0].manzil === 'uzi') {

                        var sql = `UPDATE tgusers SET asos = "15" WHERE tgid = "${msg.from.id}"`;
                        connection.query(sql, function(err, result) {
                            if (err) throw err;
                        });
                        var queryString = `SELECT telefon FROM tgusers WHERE tgid = '${msg.from.id}'`;
                            connection.query(queryString, function(err, rows, fields) {
                                if (rows[0].telefon != 'yuq'){


                                    bot.sendMessage(msg.chat.id, 'Введите свой номер телефона с кодом!');
                                }else{
                                        bot.sendMessage(msg.chat.id, 'Введите свой номер телефона с кодом! или выберите номер', {
                        reply_markup: {
                            "resize_keyboard": true,
                            "one_time_keyboard": true,
                            keyboard: [
                                [`${rows[0].telefon}`],
                            ]

                        }
                    });
                                }
                        });




                        

                    } else {
                        bot.sendMessage(msg.chat.id, `Отправить адрес`, option);

                    }
                });
            }
            if (rows[0].asos === '6') {

                if (msg.text === '✅ Утвердить заявку') {
                    var sql = `UPDATE tgusers SET asos = "0" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });

                    var queryString = `SELECT tulovturi, ism, telefon, turi, nomi, narxi, manzil, dona FROM savat WHERE tgid = '${msg.from.id}' and xolati = 'yarmchala'`;
                    var jami = '';
                    var jnarxi = 0;
                    connection.query(queryString, function(err, rows, fields) {
                        if (err) throw err;
                        if (rows[0].manzil != 'uzi') {
                            var res = rows[0].manzil.split(";");
                            bot.sendLocation('@vaqtinchaga', res[1], res[0]);
                        }
                        for (i in rows){
                            jnarxi = rows[i].narxi * rows[i].dona + jnarxi;
                            jami = jami + `\n${rows[i].nomi} * ${rows[i].dona} = ${rows[i].narxi * rows[i].dona}`;
                        }
                        jami = jami + `\n💵 Общая сумма: ${jnarxi} \n👨‍💼 Имя заказчика: ${rows[0].ism} \n📲Телефон:${rows[0].telefon} \n📟Тип обслуживания:${rows[0].turi} \n🏦 Тип оплаты:${rows[0].tulovturi}`;
                        


                        var options = {
                            reply_markup: JSON.stringify({
                                inline_keyboard: [
                                    [{
                                            text: '✅ Утвердить заявку',
                                            callback_data: JSON.stringify({
                                                'natija': 'ijobiy',
                                                'kimniki': `${msg.from.id}`
                                            })
                                        },
                                        {
                                            text: '❎ Отменить заявку',
                                            callback_data: JSON.stringify({
                                                'natija': 'salbiy',
                                                'kimniki': `${msg.from.id}`
                                            })
                                        }
                                    ]
                                ]
                            })
                        };
                        bot.sendMessage('@vaqtinchaga', `${jami}`, options);
                        
                    });
                    bot.sendMessage(msg.chat.id, `Подождите ответа аператора, который ваш заказ был отправлен на тест`, {
                        reply_markup: {
                            "resize_keyboard": true,
                            "one_time_keyboard": true,
                            keyboard: [
                                ["📋 Главное меню"],
                            ]

                        }
                    });
                    var sql = `UPDATE savat SET xolati = "tola" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });

                } else if (msg.text === '❎ Отменить заявку') {
                    var sql = `UPDATE tgusers SET asos = "0" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    var sql = `DELETE FROM savat WHERE tgid = "${msg.from.id}" and xolati = "chala"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    bot.sendMessage(msg.chat.id, 'Заказ отменен.', {
                        reply_markup: {
                            "resize_keyboard": true,
                            "one_time_keyboard": true,
                            keyboard: [
                                ["📋 Главное меню"],
                            ]

                        }
                    })
                } else {

                    bot.sendMessage(msg.chat.id, `Укажите необходимый ресурс`);
                    var sql = `UPDATE tgusers SET asos = "0" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                }

            }
            if (rows[0].asos === '4') {

                var queryString = `SELECT * FROM savat WHERE tgid = '${msg.from.id}' and xolati = 'yarmchala'`;
                connection.query(queryString, function(err, rows, fields) {
                    if (err) throw err;
                    
                        var sql = `UPDATE savat SET manzil = "${msg.location.longitude};${msg.location.latitude}" WHERE tgid = "${msg.from.id}"`;
                        connection.query(sql, function(err, result) {
                            if (err) throw err;
                        });
                    
                });
                

                var queryString = `SELECT telefon FROM tgusers WHERE tgid = '${msg.from.id}'`;
                            connection.query(queryString, function(err, rows, fields) {
                                if (rows[0].telefon === ''){


                                    bot.sendMessage(msg.chat.id, 'Введите свой номер телефона с кодом!');
                                }else{
                                        bot.sendMessage(msg.chat.id, 'Введите свой номер телефона с кодом! или выберите номер', {
                        reply_markup: {
                            "resize_keyboard": true,
                            "one_time_keyboard": true,
                            keyboard: [
                                [`${rows[0].telefon}`],
                            ]

                        }
                    });
                                }
                        });


                    var sql = `UPDATE tgusers SET asos = "15" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });





            }
            if (rows[0].asos === '5') {

               







                var sql = `UPDATE savat SET tulovturi = "${msg.text}" WHERE tgid = "${msg.from.id}" and xolati = "yarmchala"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
                var sql = `UPDATE tgusers SET asos = "6" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
                var queryString = `SELECT * FROM savat WHERE tgid = '${msg.from.id}' and xolati = 'yarmchala'`;
                connection.query(queryString, function(err, rows, fields) {
                    if (err) throw err;

                    var jami = '';
                    var jnarxi = 0;
                    for (i in rows){
                            jnarxi = rows[i].narxi * rows[i].dona + jnarxi;
                            jami = jami + `\n${rows[i].nomi} * ${rows[i].dona} = ${rows[i].narxi * rows[i].dona}`;
                        }
                        jami = jami + `\n💵 Общая сумма: ${jnarxi} \n👨‍💼 Имя заказчика: ${rows[0].ism} \n📲Телефон:${rows[0].telefon} \n📟Тип обслуживания:${rows[0].turi} \n🏦 Тип оплаты:${rows[0].tulovturi}`;
                        



                    bot.sendMessage(msg.chat.id, `${jami}`, {
                        reply_markup: {
                            "resize_keyboard": true,
                            keyboard: [
                                ["✅ Утвердить заявку"],
                                ["❎ Отменить заявку"]
                            ]

                        }
                    });
                });
            }
            if (rows[0].asos === '15') {

                var sql = `UPDATE tgusers SET telefon = "${msg.text}" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });

                var sql = `UPDATE savat SET telefon = "${msg.text}" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
                var sql = `UPDATE tgusers SET asos = "5" WHERE tgid = "${msg.from.id}"`;
                connection.query(sql, function(err, result) {
                    if (err) throw err;
                });
                bot.sendMessage(msg.chat.id, 'Какой тип оплаты вы используете?',{
                        reply_markup: {
                            "resize_keyboard": true,
                            keyboard: [
                                ["наличный оплата"],
                                ["через терминал"]
                            ]

                        }
                    })
            }
            if (rows[0].asos === '2') {



                if (msg.text === `🏃 Самовывоз`) {

                    var sql = `UPDATE savat SET turi = "${msg.text}" WHERE tgid = "${msg.from.id}" and xolati = "yarmchala"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    var sql = `UPDATE savat SET manzil = "uzi" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    var sql = `UPDATE tgusers SET asos = "3" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    bot.sendMessage(msg.chat.id, `Введите свое имя:`);

                } else if (msg.text === `🚖 Доставка`) {
                    var sql = `UPDATE savat SET turi = "${msg.text}" WHERE tgid = "${msg.from.id}" and xolati = "yarmchala"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    var sql = `UPDATE tgusers SET asos = "3" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    bot.sendMessage(msg.chat.id, `Введите свое имя`);


                } else if (msg.text === `❌ Очистка`) {
                    
                    var sql = `DELETE FROM savat WHERE tgid = "${msg.from.id}" and xolati = "yarmchala"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    var sql = `UPDATE tgusers SET asos = "0" WHERE tgid = "${msg.from.id}"`;
                    connection.query(sql, function(err, result) {
                        if (err) throw err;
                    });
                    bot.sendMessage(msg.chat.id, 'Корзина был выпущен');
                    home(msg.chat.id);


                } else {
                    bot.sendMessage(msg.chat.id, `Введите желаемый элемент`);
                }




            }


        });
    }
    });
});
bot.on('message', msg => {
    if (msg.text === 'Отменит заказа') {
        var sql = `UPDATE tgusers SET step = "home" WHERE tgid = "${msg.from.id}"`;
        connection.query(sql, function(err, result) {
            if (err) throw err;
        });
        var sql = `UPDATE tgusers SET asos = "0" WHERE tgid = "${msg.from.id}"`;
        connection.query(sql, function(err, result) {
            if (err) throw err;
        });

        bot.sendMessage(msg.chat.id, '🏫 Добро пожаловать в магазин!', {
            reply_markup: {
                "resize_keyboard": true,
                keyboard: [
                    ["📋 Меню"],
                    ["📥 Корзина", "📳 Контакты"],
                    ["🚖 Оформить заказ"]
                ]

            }
        });


    }
});

bot.on('callback_query', function onCallbackQuery(callbackQuery) {
    const data = JSON.parse(callbackQuery.data);
    const opts = {
        chat_id: callbackQuery.message.chat.id,
        message_id: callbackQuery.message.message_id,
    };
    if (data.natija === 'ijobiy') {
        bot.sendMessage(data.kimniki, "Ваш заказ подтвержден");
        bot.sendMessage(opts.chat_id, "Утвержден заказ");
    } else {
        bot.sendMessage(data.kimniki, "Ваш заказ отменен");
        bot.sendMessage(opts.chat_id, "Заказ отменен");
    }
});

function home(a){
    bot.sendMessage(a, 'Главная страница!', {
                            reply_markup: {
                                "resize_keyboard": true,
                                keyboard: [
                                    ["📋 Меню"],
                                    ["📥 Корзина", "📳 Контакты"],
                                    ["🚖 Оформить заказ"]
                                ]

                            }
                        });
}