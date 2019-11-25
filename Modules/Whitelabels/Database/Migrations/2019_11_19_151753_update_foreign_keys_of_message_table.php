<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysOfMessageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('message') && Schema::hasColumn('message', 'agent_id') && Schema::hasColumn('message', 'user_id') && Schema::hasColumn('message', 'wish_id')) {
            // Laravel schema builder can't modify/update/change column foreign keys at the current state only for updating onDelete and onUpdate, that's why had to use raw querries, first need to drop FOREIGN KEY and then recreate the constraint.
            // Schema::table('message', function (Blueprint $table) {
            //     $table->dropForeign('user_id');
            //     $table->dropForeign('wish_id');
            //     $table->dropForeign('agent_id');
            //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->change();
            //     $table->foreign('wish_id')->references('id')->on('wishes')->onDelete('cascade')->change();
            //     $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade')->change();
            // });
            \DB::statement('alter table message drop FOREIGN KEY message_user_id_foreign;');
            \DB::statement('alter table message add constraint message_user_id_foreign
                           foreign key (user_id)
                           references users(id)
                           on delete cascade;'
            );
            \DB::statement('alter table message drop FOREIGN KEY message_wish_id_foreign;');
            \DB::statement('alter table message add constraint message_wish_id_foreign
                           foreign key (wish_id)
                           references wishes(id)
                           on delete cascade;'
            );
            \DB::statement('alter table message drop FOREIGN KEY message_agent_id_foreign;');
            \DB::statement('alter table message add constraint message_agent_id_foreign
                           foreign key (agent_id)
                           references agents(id)
                           on delete cascade;'
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        \DB::statement('alter table message drop FOREIGN KEY message_user_id_foreign;');
        \DB::statement('alter table message add constraint message_user_id_foreign
                       foreign key (user_id)
                       references users(id);'
        );
        \DB::statement('alter table message drop FOREIGN KEY message_wish_id_foreign;');
        \DB::statement('alter table message add constraint message_wish_id_foreign
                       foreign key (wish_id)
                       references wishes(id);'
        );
        \DB::statement('alter table message drop FOREIGN KEY message_agent_id_foreign;');
        \DB::statement('alter table message add constraint message_agent_id_foreign
                       foreign key (agent_id)
                       references agents(id);'
        );
    }
}
