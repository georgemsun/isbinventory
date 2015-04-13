var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

/* GET ISBinventory page. */
router.get('/ISBinventory', function(req, res) {
    var db = req.db;
    var collection = db.get('inventory');
    collection.find({},{},function(e,docs){
        res.render('ISBinventory', {
            "ISBinventory" : docs
        });
    });
});

router.get('/helloworld', function(req, res){
  res.render('helloworld', {title: 'Hello, World!'})
});
module.exports = router;
