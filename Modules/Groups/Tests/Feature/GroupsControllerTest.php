<?php

namespace Modules\Groups\Tests\Feature;

use App\Models\Access\User\User;
use App\Models\Whitelabels\Whitelabel;
use Modules\Groups\Entities\Group;
use Tests\TestCase;

/**
 * Class GroupsControllerTest.
 */
class GroupsControllerTest extends TestCase
{
    /** @test */
    public function a_user_can_view_groups()
    {
        $this->actingAs($this->admin)
            ->get('/admin/groups')
            ->assertViewIs('groups::index');
    }

    /** @test */
    public function it_has_a_creator()
    {
        $this->actingAs($this->admin);

        $group = create(Group::class, ['created_by' => access()->id(), 'updated_by' => access()->id()]);

        $this->assertInstanceOf(User::class, $group->owner);

        $this->assertSame($group->owner->id, access()->id());
    }

    /** @test */
    public function it_has_a_whitelabel()
    {
        $this->actingAs($this->admin);

        $group = create(Group::class, ['whitelabel_id' => 1]);

        $this->assertInstanceOf(Whitelabel::class, $group->whitelabel);

        $this->assertSame($group->whitelabel->id, 1);
    }

    /** @test */
    public function a_user_can_delete_a_group()
    {
        $this->actingAs($this->admin);

        $group = create(Group::class);

        $this->delete(route('admin.groups.destroy', $group->id));

        $group = $group->fresh();

        $this->assertNotNull($group->deleted_at);

        $this->assertDatabaseHas('groups', ['name' => $group->name, 'id' => $group->id, 'deleted_at' => $group->deleted_at]);
    }

    /** @test */
    public function a_user_can_restore_a_group()
    {
        $this->actingAs($this->admin);

        $group = create(Group::class);

        $this->delete(route('admin.groups.destroy', $group->id));

        $group = $group->fresh();

        $this->assertNotNull($group->deleted_at);

        $this->put(route('admin.groups.restore', ['id' => $group->id]));

        $group = $group->fresh();

        $this->assertNull($group->deleted_at);

        $this->assertDatabaseHas('groups', ['name' => $group->name, 'id' => $group->id, 'deleted_at' => null]);
    }

    /** @test */
    public function a_user_can_force_delete_a_group()
    {
        $this->withExceptionHandling()->actingAs($this->admin);

        $group = create(Group::class);

        $this->delete(route('admin.groups.destroy', $group->id));

        $group = $group->fresh();

        $this->assertNotNull($group->deleted_at);

        $this->delete(route('admin.groups.forceDelete', ['id' => $group->id]));

        $this->assertNull($group->fresh());

        $this->assertDatabaseMissing('groups', ['name' => $group->name, 'id' => $group->id]);
    }
}
