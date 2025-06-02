<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all campaigns
        $campaigns = Campaign::all();
        
        // Get all user IDs
        $userIds = User::pluck('id')->toArray();
        
        // Sample comments
        $sampleComments = [
            'This is such an important cause. I hope you reach your goal soon!',
            'I just donated. Keep up the great work!',
            'How can we help spread the word about this campaign?',
            'This campaign really touched my heart. Wishing you all the best.',
            'I shared this with my friends and family. Hope it helps!',
            'What a wonderful initiative. The world needs more people like you.',
            'I have some questions about this campaign.  The world needs more people like you.',
            'I have some questions about this campaign. Can you provide more details about how the funds will be used?',
            'This is exactly the kind of project I\'ve been looking for to support!',
            'I\'ve been following your work for a while now. So glad to see this campaign.',
            'Looking forward to seeing the impact this will make in the community.',
            'Is there a way to volunteer for this cause as well?',
            'Thank you for bringing attention to this important issue.',
        ];
        
        // For each campaign, create some comments
        foreach ($campaigns as $campaign) {
            // Number of comments for this campaign (3-8)
            $numComments = rand(3, 8);
            
            for ($i = 0; $i < $numComments; $i++) {
                // Select a random user
                $userId = $userIds[array_rand($userIds)];
                
                // Select a random comment
                $content = $sampleComments[array_rand($sampleComments)];
                
                // Create the comment
                Comment::create([
                    'user_id' => $userId,
                    'campaign_id' => $campaign->id,
                    'content' => $content,
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(1, 23)),
                ]);
            }
        }
    }
}
