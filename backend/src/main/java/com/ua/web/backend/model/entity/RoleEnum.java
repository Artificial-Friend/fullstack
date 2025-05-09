package com.ua.web.backend.model.entity;

public enum RoleEnum {
    ADMIN("admin"),
    USER("user"),
    DEVOPS("devops"),
    TESTER("tester"),
    CITIZEN("citizen");

    public static final String ROLE_PREFIX = "ROLE_";
    private final String roleName;

    RoleEnum(String roleName) {
        this.roleName = roleName;
    }

    public String getRoleName(RoleEnum role) {
        return role.roleName;
    }

    public static RoleEnum getRoleEnum(String roleName) {
        for (RoleEnum role : RoleEnum.values()) {
            if (role.roleName.equals(roleName)) {
                return role;
            }
        }
        throw new IllegalArgumentException("No enum constant " + RoleEnum.class.getCanonicalName() + "." + roleName);
    }
}
