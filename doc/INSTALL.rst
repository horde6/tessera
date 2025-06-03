========================
 Installing Tessera H6
========================

:Contact: dpetrov67@gmail.com

.. contents:: Contents
.. section-numbering::

This document contains instructions for installing the Tessera ...

For information on the capabilities and features of Tessera, see the file
README_ in the top-level directory of the Tessera distribution.


Prerequisites
=============

To function properly, Tessera **requires** the following:

1. A working Horde installation.

   Tessera runs within the `Horde Application Framework`_, a set of common
   tools for web applications written in PHP.  You must install Horde before
   installing Tessera.

   .. Important:: Tessera H5 requires version 5.0+ of the Horde Framework -
                  earlier versions of Horde will **not** work.

   .. Important:: Be sure to have completed all of the steps in the
                  `horde/doc/INSTALL`_ file for the Horde Framework before
                  installing Tessera. Many of Tessera's prerequisites are
                  also Horde prerequisites. Additionally, many of Tessera's
                  optional features are configured via the Horde install.

   .. _`Horde Application Framework`: http://www.horde.org/apps/horde

2. The following PHP capabilities:



3. The following PEAR packages:
   (See `horde/doc/INSTALL`_ for instructions on installing PEAR packages)

   .. Important:: If you are going to install Tessera the recommended way,
                  i.e. using the PEAR installer, you can skip the remainder of
                  this section. Installing Tessera through PEAR will
                  automatically download and install all required PEAR modules.

4. The following PECL modules:
   (See `horde/doc/INSTALL`_ for instructions on installing PECL modules)


Installing Tessera
===================

The **RECOMMENDED** way to install Tessera is using the PEAR installer.
Alternatively, if you want to run the latest development code or get the latest
not yet released fixes, you can install Tessera from Git.

Installing from Release Tarballs
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. Important:: As of today, there are no tarballs released for Tessera 1
               yet. Please use the `Installing with PEAR`_ method to install
               Tessera 1.

Tessera can be obtained from the Horde website and FTP server, at

   http://www.horde.org/apps/Tessera

   ftp://ftp.horde.org/pub/Tessera/

Or use the mirror closest to you:

   http://www.horde.org/mirrors.php

Tessera is written in PHP, and must be installed in a web-accessible
directory. The precise location of this directory will differ from system to
system. Conventionally, Tessera is installed directly underneath Horde in the
web server's document tree.

Since Tessera is written in PHP, there is no compilation necessary; simply
expand the distribution where you want it to reside and rename the root
directory of the distribution to whatever you wish to appear in the URL. For
example, with the Apache web server's default document root of
``/usr/local/apache/htdocs``, you would type::

   cd /usr/local/apache/htdocs/horde
   tar zxvf /path/to/Tessera-h3-x.y.z.tar.gz
   mv Tessera-h3-x.y.z Tessera

and would then find Tessera at the URL::

   http://your-server/horde/tessera/

Installing from Git
~~~~~~~~~~~~~~~~~~~

See http://www.horde.org/source/git.php


Configuring Tessera
====================

1. Configuring Tessera

   You must login to Horde as a Horde Administrator to finish the
   configuration of Tessera. Use the Horde ``Administration`` menu item to
   get to the administration page, and then click on the ``Configuration``
   icon to get the configuration page. Select ``Second Factor`` from the
   selection list of applications. Fill in or change any configuration values
   as needed. When done click on ``Generate Second Factor Configuration`` to
   generate the ``conf.php`` file. If your web server doesn't have write
   permissions to the Tessera configuration directory or file, it will not be
   able to write the file. In this case, go back to ``Configuration`` and
   choose one of the other methods to create the configuration file
   ``Tessera/config/conf.php``.

   Documentation on the format and purpose of the other configuration files in
   the ``config/`` directory can be found in each file. You may create
   ``*.local.php`` versions of these files if you wish to customize Tessera's
   appearance and behavior. See the header of the configuration files for
   details and examples. The defaults will be correct for most sites.

2. Creating the database tables

   Once you finished the configuration in the previous step, you can create all
   database tables by clicking the ``DB schema is out of date.`` link in the
   Tessera row of the configuration screen.

   Alternatively creating the Tessera database tables can be accomplished with
   Horde's ``horde-db-migrate`` utility.  If your database is properly setup in
   the Horde configuration, just run the following::

      horde-db-migrate tessera

3. More instructions, upgrading, securing, etc.

4. Testing Tessera

   Once you have configured Tessera, bring up the included test page in your
   Web browser to ensure that all necessary prerequisites have been met. See
   the `horde/doc/INSTALL`_ document for further details on the Horde test
   script.

   The test script will also allow you to test...

   Next, use Tessera to.... Test at least the following:

   - Foo
   - Bar


Known Problems
==============

...


Obtaining Support
=================

If you encounter problems with Tessera, help is available!

The Horde Frequently Asked Questions List (FAQ), available on the Web at

  http://wiki.horde.org/FAQ

The Horde Project runs a number of mailing lists, for individual applications
and for issues relating to the project as a whole. Information, archives, and
subscription information can be found at

  http://www.horde.org/community/mail

Lastly, Horde developers, contributors and users may also be found on IRC,
on the channel #horde on the Freenode Network (irc.freenode.net).

Please keep in mind that Tessera is free software written by volunteers.
For information on reasonable support expectations, please read

  http://www.horde.org/community/support

Thanks for using Tessera!

The Tessera team


.. _README: README
.. _`horde/doc/INSTALL`: ../../horde/doc/INSTALL
.. _`horde/doc/TRANSLATIONS`: ../../horde/doc/TRANSLATIONS
