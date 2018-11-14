module.exports = {
	LogStart() {
		console.log('Bot ishga tushirildi...')
	},
	getChatId(msg){
		return msg.chat.id
	}
}