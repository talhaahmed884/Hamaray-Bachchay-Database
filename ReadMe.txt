• Our database follows a decent normalized form and we have tried to make it less complex for ourselves and for the instructors to evaluate. We have also posted the normalized form of our database till BCNF
• Columns with no names in datasets are for reference purposes only
• Login page does not need any specific id
• Query 14 (4th Report) requires you to insert the student_id in the SQL file/Report_Generation.php to view his/her complete record(Default: 'HB-0015') 
• The five reports are included in the webpages and not in the report
• Creation of new class/section is also provided in the webpages
• Classes have been divided w.r.t. incremental ages i.e. three-year-old for class 1, four-year-old for class 2 and so on.
• Sample IDs for insertion, deletion and updating purposes are as follows
	○ Child-ID: 1000
	○ Parent-ID: 2000
	○ Guard-ID: 3000
	○ Employee: 4000
	○ Person-ID: 5000
	○ Student-ID: 'HB-0001'
	○ Reg-ID: 'RR-0001'
	○ Reg-Hist-ID: 'RRH-0001'
	○ Challan-Num: 'C-1000'
	○ Class-Assign-ID: 'CA-0001'
	○ Class-Assign-Hist-ID: 'CID-0001'
	○ Class-ID: 1
	○ Section-ID: 'A'
	○ Course-ID: 'BB-200'
	○ Etc
• Discounts
	○ >3 kids - 50%
	○ Legit reason - 80%
	○ Teacher discount - 100%
• Registeration entity is a one-to-one relation with Admitted_Student because our database empties this entity after a term ends but records are saved Registeration_History.
• Kids aged 3,4,5 need to be accompanied by a female guardian only
• ASSUME THAT NEWLY ADMITTED TILL 12 MONTHS WITHIN ADMISSION