ElggLibTest = TestCase("ElggLibTest");

ElggLibTest.prototype.testGlobal = function() {
	assertEquals(window.location, elgg.global.window.location);
};

ElggLibTest.prototype.testProvide = function() {
	elgg.provide('foo.bar.baz');
	
	assertNotUndefined(foo);
	assertNotUndefined(foo.bar);
	assertNotUndefined(foo.bar.baz);
	
	var str = foo.bar.baz.oof = "don't overwrite me";
	
	elgg.provide('foo.bar.baz');
	
	assertEquals(str, foo.bar.baz.oof);
};

ElggLibTest.prototype.testRequire = function() {
	/* Try requiring bogus input */
	assertException(function(){ elgg.require(''); });
	assertException(function(){ elgg.require('garbage'); });
	assertException(function(){ elgg.require('gar.ba.ge'); });

	assertNoException(function(){ elgg.require('jQuery'); });
	assertNoException(function(){ elgg.require('elgg'); });
	assertNoException(function(){ elgg.require('elgg.config'); });
	assertNoException(function(){ elgg.require('elgg.security'); });
};

ElggLibTest.prototype.testInherit = function() {
	function Base() {}
	function Child() {}
	
	elgg.inherit(Child, Base);
	
	assertInstanceOf(Base, new Child());
};

ElggLibTest.prototype.testImplement = function() {
	function Base() {}
	elgg.implement(Base, {
		fun: function() {},
		str: 'only implement functions',
		num: 5,
		obj: {}
	});

	var b = new Base();
	
	assertUndefined(b.str);
	assertUndefined(b.num);
	assertUndefined(b.obj);
	
	assertNotUndefined(b.fun);
};

ElggLibTest.prototype.testExtendUrl = function() {
	var url;
	elgg.config.wwwroot = "http://www.elgg.org/";
	
	url = '';
	assertEquals(elgg.config.wwwroot, elgg.extendUrl(url));
	
	url = 'pg/test';
	assertEquals('http://www.elgg.org/pg/test', elgg.extendUrl(url));
};







