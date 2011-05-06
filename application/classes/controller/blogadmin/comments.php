<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BlogAdmin_Comments extends Controller_BlogAdmin
{
	public function action_index($comment_status = 'pending')
	{
		$total_count = Model_Blog_Comment::count_comments($comment_status);
		$page_number = !empty($_GET['page']) ? $_GET['page'] : 1;
		$pagination = Pagination::factory(array(
			'total_items' => $total_count,
			'items_per_page' => 30,
			//'view' => 'includes/pagination',
		));
		
		$comments = ORM::factory('Blog_Comment')
			->where('status', '=', $comment_status)
			->order_by('id', 'desc')
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->find_all();
			
		$page = View::factory('blog/admin/comments')
			->set('comment_status', ucfirst($comment_status))
			->bind('comments', $comments)
			->set('pagination', $pagination->render());
			
		$this->template
			->set('title', 'Comment Administration')
			->bind('content', $page);
	}
	
	public function action_action($comment_id)
	{
		$comment = ORM::factory('Blog_Comment', $comment_id);
		$post = $comment->post;
		
		if (isset($_POST['spam']))
		{
			$comment->status = 'spam';
			// TODO: Akismet
		}
		elseif (isset($_POST['ham']))
		{
			$comment->status = 'visible';
			// TODO: Akismet
		}
		elseif (isset($_POST['approve']))
		{
			$comment->status = 'visible';
		}
		elseif (isset($_POST['unapprove']))
		{
			$comment->status = 'hidden';
		}
		elseif (isset($_POST['delete']))
		{
			$comment->delete();
			// Go back to where they came from
			$this->request->redirect($this->request->referrer());
		}
		else
		{
			die('Unknown action!');
		}
		
		$comment->save();
		$post->recalculate_comments();
		
		// Go back to where they came from
		$this->request->redirect($this->request->referrer());
	}
}
?>