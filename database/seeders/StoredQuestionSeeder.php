<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StoredQuestion;



class StoredQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [['自宅の最寄り駅周辺の状況に関して説明してください。', 'My neighborhood is a mix of quiet residential streets and bustling commercial areas. There are plenty of parks and green spaces, which I appreciate. The local shops and restaurants offer a variety of cuisines and services, making it convenient to find what I need. The public transportation system is reliable, making it easy to get around the city. Overall, it\'s a pleasant and convenient place to live.'],

['自分が幸せだと思うことと、その理由を教えてください。', 'I find happiness in the simple things, like a good book or a walk in nature. Spending time with loved ones always brings me joy. I also feel happy when I\'m able to help others, even in small ways. Learning something new or mastering a skill makes me feel accomplished and happy. Finally, I believe that having a positive outlook and gratitude for what I have contributes greatly to my overall happiness.'],

['家に帰ってきた時の部屋の中の様子を説明してください。', 'When I come home, I like to relax and unwind. I might listen to music, read a book, or watch a movie. I also enjoy cooking and trying new recipes. Sometimes I\'ll invite friends over for dinner or drinks. It\'s a great way to catch up and socialize.'],

['冬にやりたくないことと、その理由を教えてください。', 'In winter, I don\'t like dealing with the cold weather. I prefer to stay indoors where it\'s warm and cozy. I also don\'t like having to shovel snow or drive in icy conditions. Winter can be a beautiful season, but I prefer to enjoy it from the comfort of my home.'],

['Saleの時に買い物をすることは好きですか？その答えの理由も教えてください。', 'I enjoy shopping during sales because I can get more for my money. It\'s a great feeling to find something I want at a discounted price. However, I also try to be mindful of my spending habits and avoid buying things I don\'t need just because they\'re on sale.'],

['自分にとって好きな場所と、その理由を教えてください。', 'My favorite place is the beach. I love the sound of the waves crashing against the shore and the feel of the sand between my toes. The beach is a great place to relax and escape from the stresses of everyday life. I also enjoy swimming, sunbathing, and playing beach volleyball.'],

['自分の人生で影響を受けた人物に関して説明してください。', 'One person who has influenced my life is my grandmother. She was a strong and independent woman who taught me the importance of hard work and perseverance. She also instilled in me a love of learning and a passion for helping others. I am grateful for her guidance and support.'],

['運転免許の取得方法に関して説明してください。', 'To obtain a driver\'s license, I had to complete a driver\'s education course and pass a written and driving test. The process was challenging at times, but it was ultimately rewarding to achieve my goal. Having a driver\'s license gives me a sense of freedom and independence.'],

['自分の好きなスポーツの試合のやり方に関して教えてください。', 'I enjoy watching basketball games. The fast-paced action and the athleticism of the players are exciting to watch. I also enjoy the strategic aspects of the game, such as the different offensive and defensive plays. Basketball is a great team sport that requires skill, coordination, and communication.'],

['最近の印象的なニュースに関して説明してください。', 'A recent news story that caught my attention was about the advancements in artificial intelligence. I am fascinated by the potential of AI to solve complex problems and improve our lives. However, I am also aware of the potential risks associated with AI, such as job displacement and ethical concerns. It\'s important to have a thoughtful and balanced discussion about the future of AI.'],

['自由時間にすることは何？', 'In my free time, I enjoy reading, writing, and spending time with my friends and family. I also like to explore new hobbies and interests. Recently, I\'ve been learning how to play the guitar. It\'s challenging but also very rewarding.'],

['恋人と別れた女性友達をどの様に慰める？', 'If a female friend is going through a breakup, I would offer her my support and listen to her without judgment. I would also encourage her to focus on her own needs and well-being. It\'s important to give her time to heal and remind her that she is loved and valued.'],

['学生の時に所属していたクラブは？', 'In school, I was a member of the debate club. I enjoyed the challenge of researching different topics and formulating arguments. The debate club helped me develop my critical thinking and public speaking skills. It was also a great way to meet new people and make friends.'],

['待ち合わせの友人が来ない時どうする？', 'If a friend is late, I would try to be patient and understanding. I would give them a reasonable amount of time before contacting them to check if everything is alright. It\'s possible that they encountered unexpected circumstances.'],

['休日時間があるときにあなたはどのような対応をしますか？', 'On a free day, I like to be spontaneous and go with the flow. I might visit a museum, explore a new neighborhood, or simply relax at home. It depends on my mood and the weather. I enjoy having the freedom to choose what I want to do.'],

['あなたが好きなアウトドアスポーツはなんですか？', 'I enjoy hiking and camping. Being outdoors in nature is refreshing and invigorating. I love the challenge of hiking up a mountain and the sense of accomplishment when I reach the summit. Camping allows me to disconnect from technology and appreciate the simple things in life.'],

['友人の部屋がちらかっていたらどんなアドバイスする？', 'If a friend\'s room is cluttered, I would offer to help them organize and declutter. I would suggest starting with one area at a time and focusing on items that are no longer needed or used. It can be a daunting task, but breaking it down into smaller steps can make it more manageable.'],

['金曜日の夜に普段あなたは何をしていますか？', 'On Friday nights, I like to relax and unwind after a long week. I might order takeout, watch a movie, or catch up on my reading. Sometimes I\'ll go out with friends for dinner or drinks. It\'s a great way to de-stress and recharge for the weekend.'],

['親や、友人、車のことについて説明してください。', 'My family is supportive and loving. My friends are loyal and trustworthy. My car is reliable and gets me where I need to go. I am grateful for all of them.'],

['最近参加したセレモニーについて説明してください。', 'Recently, I attended a friend\'s wedding ceremony. It was a beautiful and joyous occasion. I was happy to celebrate with my friend and witness their commitment to each other.'],

['あなたの友人が新会社を立ち上げ、あなたに出資を求めています。もっともらしい理由で断ってください。', 'If a friend asks me to invest in their new company, I would politely decline, explaining that I am not in a position to make any investments at this time. I would wish them all the best in their new venture and offer my support in other ways.'],

['お気に入りの服が汚れたときどうしますか。', 'If I spill something on my favorite shirt, I would try to clean it as soon as possible. I would follow the care instructions on the label and use a stain remover if necessary. If the stain is stubborn, I might take it to a professional cleaner.'],

['上司と意見が食い違ったときどうしますか。', 'If I disagree with my boss, I would try to express my opinion respectfully and professionally. I would listen to their perspective and try to find common ground. It\'s important to maintain a positive working relationship, even when there are disagreements.'],

['待ち合わせをしていた友人が現れないときにあなたはどのような対応をしますか。', 'If a friend is late, I would try to be patient and understanding. I would give them a reasonable amount of time before contacting them to check if everything is alright. It\'s possible that they encountered unexpected circumstances.'],

['友人が忙しくて疲れているときどんなアドバイスをしますか。', 'If a friend is busy and stressed, I would encourage them to take some time for themselves to relax and recharge. I would offer to help them with any tasks or errands they might have. It\'s important to support our friends during challenging times.'],

['友人の納得がいくようにアドバイスしてください。', 'If a friend\'s room is cluttered, I would offer to help them organize and declutter. I would suggest starting with one area at a time and focusing on items that are no longer needed or used. It can be a daunting task, but breaking it down into smaller steps can make it more manageable.'],

['友人の部屋が散らかっているときにあなたはどのようなアドバイスをしますか', 'If a friend\'s room is cluttered, I would offer to help them organize and declutter. I would suggest starting with one area at a time and focusing on items that are no longer needed or used. It can be a daunting task, but breaking it down into smaller steps can make it more manageable.']];



    foreach($questions as $q){
        StoredQuestion::create([
            'Q' => $q[0],
            'A' => $q[1],
        ]);
    }

    }
}

