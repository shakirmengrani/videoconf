var express = require("express");
var router = express.Router();
router.get('/',function(req,res){
	res.render('demo_audio_video');
});
module.exports = router;