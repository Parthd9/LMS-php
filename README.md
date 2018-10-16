# LMS-php
Some common features of Library Management System for librarians and users.
Database:lms
Tables:
book(id(primary),book_name,book_author,book_quantity,book_price)
book_detail(id(primary),department,subject,book)
issue(uname,book_name,subject,department,time)
librarian(uname(primary),password)
reserve(r_id(primary),uname,book_id,r_date)
userdetail(uname(primary),name,u_email,u_address,u_password)
