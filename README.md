# Mad Splash - Tropical
Aloha! This is a historical archive of Mad Splash in it's last Tropical iteration. The code is bad, there's no
framework, and there's very little convention. The `master` branch will remain an untouched record of the past,
and the `update` branch is being working on as a functional version of the site so you can interact with a
piece of history. 😁

## History
At the time a lot of people inspired me to make Mad Splash, and this site. This site is how I learned to code
and it was a project that took me a lot of time. I'm happy I'm able to preserve it and keep it going today.

## Known Issues
These are the known issues at the moment;
- Password hashing uses non-cryptographic salts and MD5 for hashing. It's a freakin' nightmare. This will
be updated to use argon2 going forward.
- No controllers! The site was made before I fully understood the MVC website model; there's a lot of weird
ways of handling requests and data that aren't normalized.
- Redundant code; I reimplemented a lot of default behaviors by mistake as I was following various books
and tutorials. This code will be cleaned up over time.

## Hosting
The `master` branch was built on early versions of PHP; I believe the primary being PHP 5.4 and then PHP 7.0
later on. Simply point your web server to the root folder and let it rip.

The `update` branch is being built on PHP 8.4 at the time of writing, and any deprecated code is being replaced
and I'm putting in gradual typing. Point your web server to the `public/` folder and you're good to go!
