
!!!!!!!!!!!!! ALL REQUESTS SHOULD HAVE header "Accept" = "application/json" !!!!!!!!!!!!!!

1. Category List

	URL : {home_ul}/api/category/list
	METHOD : GET
	RETURNS : List of questions.

2. Get all questions regardless of category

	URL : {home_ul}/api/questions
	METHOD : GET
	RETURNS : List of questions.

3. Get questions by categories

	URL : {home_ul}/api/questions/category/{category_id}
	METHOD : GET
	RETURNS : List of questions.

4. Create a question

	URL : {home_ul}/api/questions/create
	METHOD : POST
	HEADERS : Authorization
	PARAMS : question, answer_1, answer_2, answer_3, answer_4, category_id
	RETURNS : Created question.

5. Post a vote

	URL : {home_ul}/api/vote
	METHOD : POST
	HEADERS : Authorization
	PARAMS : question_id, answer_id
	RETURNS : Votes for each answer.

6. Post a comment

	URL : {home_ul}/api/comment
	METHOD : POST
	HEADERS : Authorization
	PARAMS : question_id, comment
	RETURNS : Comment object.